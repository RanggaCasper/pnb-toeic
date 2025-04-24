<?php

namespace App\Http\Controllers\User\Exam;

use Carbon\Carbon;
use App\Models\UserAnswer;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use App\Models\Section\Section;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller implements \Illuminate\Routing\Controllers\HasMiddleware
{
    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }

    public function index()
    {
        $sectionId = session('current_section_id');
        $token = session('token_data');

        if (!$sectionId && $token) {
            $firstSection = $this->getSections($token->bank_id)->first();
            $sectionId = $firstSection?->id;
            session(['current_section_id' => $sectionId]);
        }

        $section = Section::find($sectionId);
        
        $time = Carbon::now()->diffInSeconds(Carbon::parse($token->end_at), false);

        return view('user.exam.index', compact('section', 'time'));
    }

    public function get()
    {
        try {
            $sectionId = session('current_section_id');
            $section = Section::with('questions')->findOrFail($sectionId);

            $html = view('user.exam.question.section', [
                'data' => $section,
                'questions' => $section->questions,
            ])->render();

            return ResponseFormatter::success('Section loaded.', $html);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function saveAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|string|in:A,B,C,D',
        ]);

        session()->put("answers.{$request->question_id}", $request->answer);

        return response()->json(['message' => 'Answer saved in session']);
    }

    public function saveAllAnswers(Request $request)
    {
        $token = session('token_data');
        $answers = session('answers', []);
        $currentSectionId = session('current_section_id');

        if (!$answers) {
            return response()->json(['message' => 'No answers found in session.'], 400);
        }

        $sections = $this->getSections($token->bank_id);
        $currentIndex = $sections->search(fn($section) => $section->id == $currentSectionId);

        if ($currentIndex === false) {
            return response()->json(['message' => 'Current section not found.'], 404);
        }

        $currentSection = $sections[$currentIndex];
        $unanswered = $currentSection->questions->reject(fn($q) => isset($answers[$q->id]));

        if ($unanswered->isNotEmpty()) {
            return response()->json([
                'message' => 'Please answer all questions before proceeding.',
                'unanswered_questions' => $unanswered->pluck('id')
            ], 400);
        }

        foreach ($answers as $questionId => $answer) {
            UserAnswer::updateOrCreate(
                ['user_id' => Auth::id(), 'question_id' => $questionId, 'token_id' => $token->id],
                ['answer' => $answer]
            );
        }

        session()->forget('answers');

        $nextSection = $sections->get($currentIndex + 1);

        if ($nextSection) {
            session(['current_section_id' => $nextSection->id]);
            return ResponseFormatter::redirected(
                'Answers saved successfully. Moving to next section.',
                route('user.exam.index')
            );
        }

        session()->forget('current_section_id');
        return ResponseFormatter::redirected('Exam completed successfully.', route('home'));
    }

    public function reset()
    {
        session()->forget('current_section_id');
        session()->forget('answers');

        return ResponseFormatter::success('Exam session cleared.');
    }

    /**
     * Get and sort sections by bank ID.
     */
    private function getSections($bankId)
    {
        return QuestionBank::with('sections.questions')
            ->findOrFail($bankId)
            ->sections
            ->sortBy('section_name_id')
            ->values();
    }
}
