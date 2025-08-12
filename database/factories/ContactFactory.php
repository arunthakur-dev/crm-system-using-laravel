<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'owner' => function (array $attributes) {
                return User::find($attributes['user_id'])->name ?? "No Owner";
            },
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'lead_status' => fake()->randomElement(['New', 'Open', 'Open Deal', 'In Progress', 'Connected']),
            'logo' => fake()->imageUrl(),
        ];
    }
}
