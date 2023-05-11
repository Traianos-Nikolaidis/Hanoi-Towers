<?php

namespace App\Http\Controllers;


use App\Models\Quiz;
use App\Models\Stat;
use App\Models\User;

class StatController extends Controller
{

    public function index()
    {
        $users = User::all();
        $userStats = [];

        foreach ($users as $user) {
            $stats = Stat::where('player_id', $user->id)->get();
            $totalStats = [
                'correct_moves' => 0,
                'wrong_moves' => 0,
                'time_played' => 0,
                'completed' => 0,
            ];

            foreach ($stats as $stat) {
                $totalStats['correct_moves'] += $stat->correct_moves;
                $totalStats['wrong_moves'] += $stat->wrong_moves;
                $totalStats['time_played'] += $stat->time_played;
                if ($stat->completed == "success")
                    $totalStats['completed']++;
            }

            $userStats[] = [
                'user' => $user,
                'stats' => $totalStats,
            ];
        }

        return view('stats.index', compact('userStats'));
    }
    public function userQuizzes(User $user)
    {
        $quizIds = Stat::where('player_id', $user->id)->distinct('quiz_id')->pluck('quiz_id')->toArray();
        $quizzes = Quiz::whereIn('id', $quizIds)->paginate(20);

        return view('stats.user-quizzes', compact('user', 'quizzes'));
    }

    public function userQuizStats(User $user, Quiz $quiz)
    {
        $stats = Stat::where('player_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->paginate(20);

        return view('stats.user-quiz-stats', compact('user', 'quiz', 'stats'));
    }
}
