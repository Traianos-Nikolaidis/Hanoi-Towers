<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stat;
use App\Models\Quiz;
use App\Models\User;

class StatFactory extends Factory
{
    protected $model = Stat::class;

    public function definition()
    {
        $quiz = Quiz::inRandomOrder()->first();
        $hanoiuser = User::inRandomOrder()->first();

        return [
            'player_id' => $hanoiuser->id,
            'quiz_id' => $quiz->id,
            'correct_moves' => $this->faker->numberBetween(1, 100),
            'wrong_moves' => $this->faker->numberBetween(1, 100),
            'time_played' => $this->faker->numberBetween(10, 1800),
            'ip_address' => $this->faker->ipv4(),
            'date_played' => $this->faker->dateTimeBetween($quiz->start_date, $quiz->end_date),
            'completed' => $this->faker->randomElement(['success', 'fail']),
        ];
    }
}