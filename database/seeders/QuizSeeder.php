<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\User;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $hanoiusers = User::all();

        // Create 20 quizzes for each hanoiuser
        foreach ($hanoiusers as $hanoiuser) {
            Quiz::factory()->count(5)->create([
                'creator_id' => $hanoiuser->id,
            ]);
        }
    }
}
