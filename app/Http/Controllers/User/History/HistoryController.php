<?php

namespace App\Http\Controllers\User\History;

use App\Models\History;
use App\Models\Question;
use App\Models\ToeicScore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;
use Carbon\Carbon;
use App\Models\TestSession;
use App\Models\QuestionBank;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get unique bank IDs from user's history
        $bankIds = History::with(['question.section.questionBank'])
            ->where('users_id', $user->id)
            ->get()
            ->pluck('question.section.questionBank.id')
            ->unique()
            ->filter();

        $bankResults = collect();

        foreach ($bankIds as $bankId) {
            $result = $this->calculateBankScore($user->id, $bankId);
            if ($result['success'] && $result['data']) {
                $bankResults->push($result['data']);
            }
        }

        return view('user.history.index', [
            'test_sessions' => $bankResults->sortByDesc('test_taken')->values()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $question = Question::findOrFail($request->questions_id);
            
            $userAnswer = strtoupper($request->user_answer);
            $correctAnswer = strtoupper($question->answer);
            
            // Log the answer comparison for debugging
            Log::info('Answer comparison', [
                'user_answer' => $userAnswer,
                'correct_answer' => $correctAnswer,
                'question_id' => $question->id
            ]);

        History::create([
                'users_id' => Auth::id(),
                'questions_id' => $request->questions_id,
                'user_answer' => $request->user_answer
        ]);

        return response()->json([
            'success' => true,
            'message' => 'History saved successfully',
                'is_correct' => $userAnswer === $correctAnswer
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving history: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'question_id' => $request->questions_id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save history'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        //
    }

    /**
     * Calculate scores for a specific user and question bank
     * 
     * @param int $userId
     * @param int $bankId
     * @return array
     */
    private function calculateBankScore($userId, $bankId)
    {
        try {
            $histories = History::with(['question.section.sectionName', 'question.section.questionBank'])
                ->whereHas('question.section.questionBank', function($query) use ($bankId) {
                    $query->where('id', $bankId);
                })
                ->where('users_id', $userId)
                ->get();

            if ($histories->isEmpty()) {
                return [
                    'success' => false,
                    'message' => 'No history found for this user and bank',
                    'data' => null
                ];
            }

            // Count correct answers for reading sections
            $readingCorrect = $histories->filter(function($history) {
                return $history->question?->section?->sectionName?->type === 'reading' 
                    && strtoupper($history->user_answer) === strtoupper($history->question->answer);
            })->count();

            // Count correct answers for listening sections
            $listeningCorrect = $histories->filter(function($history) {
                return $history->question?->section?->sectionName?->type === 'listening'
                    && strtoupper($history->user_answer) === strtoupper($history->question->answer);
            })->count();

            // Get scores from ToeicScore table
            $readingScore = ToeicScore::where('correct', $readingCorrect)
                ->value('reading_score') ?? 0;

            $listeningScore = ToeicScore::where('correct', $listeningCorrect)
                ->value('listening_score') ?? 0;

            Log::info('Score calculation', [
                'reading_correct' => $readingCorrect,
                'listening_correct' => $listeningCorrect,
                'reading_score' => $readingScore,
                'listening_score' => $listeningScore
            ]);

            $totalScore = $readingScore + $listeningScore;
            $latestAttempt = $histories->max('created_at');
            $bank = $histories->first()->question->section->questionBank;

            return [
                'success' => true,
                'data' => [
                    'reading_score' => $readingScore,
                    'listening_score' => $listeningScore,
                    'total_score' => $totalScore,
                    'test_taken' => $latestAttempt,
                    'bank_name' => $bank->name,
                    'test_type' => ucfirst($bank->type),
                    'bank_id' => $bank->id,
                    'reading_correct' => $readingCorrect,
                    'listening_correct' => $listeningCorrect
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Error calculating bank score', [
                'user_id' => $userId,
                'bank_id' => $bankId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error calculating score: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function certificate(Request $request)
    {
        $timestamp = $request->timestamp;
        $bankId = $request->bank;
        
        // Calculate scores
        $result = $this->calculateBankScore(auth()->id(), $bankId);
        if (!$result['success'] || !$result['data']) {
            return abort(404);
        }

        $data = $result['data'];
        $bank = QuestionBank::find($bankId);
        $isTryout = strtolower($bank->name) === 'tryout' || 
                    str_contains(strtolower($bank->name), 'tryout') ||
                    strtolower($bank->test_type) === 'tryout';

        // Calculate level and readiness based on total score
        $level = $this->calculateLevel($data['total_score']);
        $readiness = $this->calculateReadiness($data['total_score']);

        $viewData = [
            'user_name' => auth()->user()->name,
            'test_date' => Carbon::parse($timestamp)->format('d F Y'),
            'listening_score' => $data['listening_score'],
            'reading_score' => $data['reading_score'],
            'total_score' => $data['total_score'],
            'level' => $level,
            'readiness' => $readiness,
            'test_taken' => $timestamp,
            'bank_id' => $bankId
        ];

        return view('user.history.certificate', $viewData);
    }

    public function download(Request $request)
    {
        $timestamp = $request->timestamp;
        $bankId = $request->bank;
        
        // Calculate scores
        $result = $this->calculateBankScore(auth()->id(), $bankId);
        if (!$result['success'] || !$result['data']) {
            return abort(404);
        }

        $data = $result['data'];
        $bank = QuestionBank::find($bankId);
        $isTryout = strtolower($bank->name) === 'tryout' || 
                    str_contains(strtolower($bank->name), 'tryout') ||
                    strtolower($bank->test_type) === 'tryout';

        // Calculate level and readiness based on total score
        $level = $this->calculateLevel($data['total_score']);
        $readiness = $this->calculateReadiness($data['total_score']);

        $pdfData = [
            'user_name' => auth()->user()->name,
            'test_date' => Carbon::parse($timestamp)->format('d F Y'),
            'listening_score' => $data['listening_score'],
            'reading_score' => $data['reading_score'],
            'total_score' => $data['total_score'],
            'level' => $level,
            'readiness' => $readiness
        ];

        $pdf = PDF::loadView('user.history.template', $pdfData);
        
        return $pdf->download('toeic_score_report.pdf');
    }

    private function calculateLevel($totalScore)
    {
        if ($totalScore >= 945) return 'Proficient user - Effective Operational Proficiency (C1)';
        if ($totalScore >= 785) return 'Independent user - Vantage (B2)';
        if ($totalScore >= 550) return 'Independent user - Threshold (B1)';
        if ($totalScore >= 225) return 'Basic user - Waystage (A2)';
        if ($totalScore >= 120) return 'Basic user - Breakthrough (A1)';
        return 'Beginner';
    }

    private function calculateReadiness($totalScore)
    {
        if ($totalScore >= 905) return '95% chance to achieve Advanced level TOEIC (905-990)';
        if ($totalScore >= 785) return '90% chance to achieve Upper Intermediate level TOEIC (785-900)';
        if ($totalScore >= 405) return '80% chance to achieve Intermediate level TOEIC (405-600)';
        if ($totalScore >= 255) return '70% chance to achieve Elementary level TOEIC (255-400)';
        return 'Recommended to improve basic English skills before taking TOEIC';
    }
}
