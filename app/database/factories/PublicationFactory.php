<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Document;
use App\Models\PublishingHouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->unique()->sentence(),
            'publication_year' => $this->faker->unique()->year(),
            'publication_century' => 20,
            'user_id' => User::first(),
            'publishing_house_id' => PublishingHouse::first(),
            'document_id' => Document::first()
        ];
    }
}
