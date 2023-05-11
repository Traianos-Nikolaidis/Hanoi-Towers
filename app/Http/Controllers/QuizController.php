<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Stat;
use Illuminate\Http\Request;

class QuizController extends Controller
{
public function index(Request $request)
{
    $available = $request->query('available', false);

    if ($available) {
        $quiz = Quiz::where('start_date', '<=', now())
            ->where('end_date', '>=', now())->where('for_who','!=','guests')
            ->paginate(20);
    } else {
        $quiz = Quiz::paginate(20);
    }

    return view('quiz.index', compact('quiz','available'));
}
    public function create()
    {
        return view('quiz.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'number_of_discs' => 'required|integer|min:1',
            'number_of_tries' => 'required|integer|min:1',
            'for_who' => 'required|in:all,guests,users',
            'pre_game_link' => 'required|url',
            'post_game_link' => 'required|url',
        ]);

        $quiz = new Quiz($request->all());
        $quiz->creator_id = $request->user()->id;
        $quiz->save();

        return redirect()->route('quiz.create')->with('success', 'Quiz created successfully.');
    }
    public function averages()
    {
        $quizzes = Quiz::paginate(20);

        $averages = $quizzes->map(function ($quiz) {
            $stats = Stat::where('quiz_id', $quiz->id)->get();

            $average = [
                'quiz_name' => $quiz->name,
                'correct_moves' => $stats->avg('correct_moves'),
                'wrong_moves' => $stats->avg('wrong_moves'),
                'time_played' => $stats->avg('time_played'),
            ];

            return $average;
        });
        return view('quiz.averages', ['averages' => $averages, 'quizzes' => $quizzes]);
        //return view('quiz.averages', compact('averages'));
    }
}
