<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stat;
use App\Models\Quiz;
use App\Models\User;

class StatSeeder extends Seeder
{
    public function run()
    {
        $hanoiusers = User::all();
        $quizzes = Quiz::all();

        // Create 100 stats for each combination of hanoiuser and quiz
        foreach ($hanoiusers as $hanoiuser) {
            foreach ($quizzes as $quiz) {
                Stat::factory()->count(5)->create([
                    'player_id' => $hanoiuser->id,
                    'quiz_id' => $quiz->id,
                ]);
            }
        }
    }
}
