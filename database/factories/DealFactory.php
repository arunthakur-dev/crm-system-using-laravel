<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'owner' => function (array $attributes) {
                return User::find($attributes['user_id'])->name ?? "No Owner";
            },
            'title' => fake()->catchPhrase(),
            'amount' => fake()->numberBetween(1000, 50000),
            'status' => fake()->randomElement(['open', 'won', 'lost']),
            'close_date' => fake()->dateTime(),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
        ];
    }
}
