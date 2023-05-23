<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $begin_at = $this->faker->dateTimeBetween('-2 day', '+3 week');
        $finish_at = $this->faker->dateTimeBetween($begin_at, '+6 weeks');

        $beginned_at = Carbon::instance($begin_at)->isBefore(now()) ? $this->faker->dateTimeBetween('-2 day', $begin_at) : null;
        $finished_at = Carbon::instance($finish_at)->isBefore(now()) ? $this->faker->dateTimeBetween($finish_at, '+6 week') : null;

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->text(),
            'level' => $this->faker->randomElement(['low', 'medium', 'high']),
            'user_id' => 7,
            'begin_at' => $begin_at,
            'finish_at' => $finish_at,
            'beginned_at' => $beginned_at,
            'finished_at' => $finished_at,
        ];
    }
}
