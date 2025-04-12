<?php

namespace App\Http\Controllers\User\History;

use App\Models\History;
use App\Models\Question;
use App\Models\ToeicScore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();
        
        // Mengambil seluruh history jawaban user beserta relasinya
        $histories = History::with(['question.section.sectionName'])
            ->where('users_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Inisialisasi counter jawaban benar
        $correctReading = 0;
        $correctListening = 0;
        $totalReading = 0;
        $totalListening = 0;

        // Loop setiap history untuk menghitung jawaban benar per section
        foreach ($histories as $history) {
            if ($history->question && $history->question->section && $history->question->section->sectionName) {
                $sectionType = $history->question->section->sectionName->type;
                $userAnswer = strtoupper($history->user_answer);
                $correctAnswer = strtoupper($history->question->answer);
                
                if ($sectionType === 'reading') {
                    $totalReading++;
                    if ($userAnswer === $correctAnswer) {
                        $correctReading++;
                    }
                } elseif ($sectionType === 'listening') {
                    $totalListening++;
                    if ($userAnswer === $correctAnswer) {
                        $correctListening++;
                    }
                }
            }
        }

        // Mengambil skor reading berdasarkan jumlah jawaban benar reading
        $readingToeicScore = ToeicScore::where('correct', $correctReading)->first();
        $readingScore = $readingToeicScore ? $readingToeicScore->reading_score : 0;

        // Mengambil skor listening berdasarkan jumlah jawaban benar listening
        $listeningToeicScore = ToeicScore::where('correct', $correctListening)->first();
        $listeningScore = $listeningToeicScore ? $listeningToeicScore->listening_score : 0;

        // Menampilkan view dengan data yang diperlukan
        return view('user.history.index', compact('histories', 'readingScore', 'listeningScore', 'totalReading', 'totalListening'));
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
}
