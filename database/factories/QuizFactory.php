<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition()
    {
        $minStartDate = Carbon::now()->subYears(1);
        $maxStartDate = Carbon::now();
        $startDate = Carbon::createFromTimestamp($this->faker->dateTimeBetween($minStartDate, $maxStartDate)->getTimestamp());
        $endDate = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate, $startDate->copy()->addMonths(6))->getTimestamp());

        return [
            'name' => $this->faker->word(),
            'start_date' =>  $startDate,
            'end_date' => $endDate,
            'number_of_discs' => $this->faker->numberBetween(3, 5),
            'number_of_tries' => $this->faker->numberBetween(1, 3),
            'for_who' => $this->faker->randomElement(['all', 'guests', 'users']),
            'pre_game_link' => $this->faker->url(),
            'post_game_link' => $this->faker->url(),
            'creator_id' => User::inRandomOrder()->first(),
        ];
    }
}
