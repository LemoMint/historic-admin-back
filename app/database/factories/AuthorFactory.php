<?php

namespace Database\Factories;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->name(),
            'surname' => fake()->lastName(),
            'patronymic_name' => null,
            'user_id' => User::first() ? User::first()->id : User::factory()->create()->id
        ];
    }
}
