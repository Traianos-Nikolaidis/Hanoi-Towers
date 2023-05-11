<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Stat;
use Illuminate\Http\Request;

class ProfessorQuizController extends Controller
{
    public function stats(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'professor') {
            return redirect('/')->with('error', 'Access denied.');
        }

        $quizzes = Quiz::where('creator_id', $user->id)->get();

        $quizStats = $quizzes->map(function ($quiz) {
            $stats = Stat::where('quiz_id', $quiz->id)->get();

            return [
                'quiz_name' => $quiz->name,
                'correct_moves' => $stats->avg('correct_moves'),
                'wrong_moves' => $stats->avg('wrong_moves'),
                'time_played' => $stats->avg('time_played'),
            ];
        });
        return view('professor.quizzes.stats', compact('quizStats'));
    }

    public function quizStats(Request $request, Quiz $quiz)
    {
        $user = $request->user();

        $stats = Stat::where('quiz_id', $quiz->id)->with('player')->get();

        return view('professor.quizzes.quiz_stats', compact('quiz', 'stats'));
    }
}
