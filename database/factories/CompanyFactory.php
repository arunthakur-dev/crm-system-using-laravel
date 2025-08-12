<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'owner' => function (array $attributes) {
                return User::find($attributes['user_id'])->name ?? "No Owner";
            },
            'name' => fake()->company(),
            'logo' => fake()->imageUrl(),
            'domain' => fake()->domainName(),
            'industry' => fake()->randomElement(['Technology', 'Finance', 'Healthcare', 'Education', 'Retail', 'Hospitality']),
            'phone' => fake()->phoneNumber(),
            'country' => fake()->country(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'notes' => fake()->paragraph(),
        ];
    }
}
