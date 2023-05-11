<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Stat;
use Illuminate\Http\Request;

class UserQuizController extends Controller
{
    public function myStats(Request $request)
    {
        $user = $request->user();
        $stats = Stat::where('player_id', $user->id)->with('quiz')->paginate(25);

        return view('users.my_stats', compact('stats'));
    }
    public function clearStats(Request $request)
    {
        $user = $request->user();
        Stat::where('player_id', $user->id)->delete();

        return redirect()->route('my-stats')->with('success', 'Personal stats cleared successfully.');
    }


    public function submit(Request $request)
    {
        
        $user = $request->user();

        // Validate the submitted data
        $validated = $request->validate([
            'correct_moves' => 'required|integer',
            'wrong_moves' => 'required|integer',
            'time_played' => 'required|integer',
        ]);

        // Save the submitted data to the stats table
        Stat::create([
            'player_id' => $user->id,
            'quiz_id' => $request->quiz_id,
            'correct_moves' => $validated['correct_moves'],
            'wrong_moves' => $validated['wrong_moves'],
            'time_played' => $validated['time_played'],
            'ip_address' => $request->ip(),
            'date_played' => now(),
            'completed' => $request->completed,
        ]);
        //return response()->json(['message' => 'Data saved successfully!']);
        return redirect()->route('my-stats')->with('success', 'Results submitted successfully.');
    }
    public function play(Request $request, Quiz $quiz)
    {
        $now = Carbon::now();

        if (($quiz->for_who === 'guests' && $request->user()) || !$now->between($quiz->start_date, $quiz->end_date)) {
            abort(403, 'This quiz is only available for guests and within the date range.');
        } elseif (($quiz->for_who === 'users' && !$request->user()) || !$now->between($quiz->start_date, $quiz->end_date)) {
            abort(403, 'This quiz is only available for authenticated users and within the date range.');
        }

        return view('users.play', compact('quiz'));
    }
}
