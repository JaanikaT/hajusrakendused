<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mmo\Faker\PicsumProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(PicsumProvider::class);
        
        return [
            'title'=> fake()->sentence(2),
            'image' => fake()->picsumUrl(400, 400),
            'description' => fake()->sentence(),
            'comfort'=> fake()->randomDigitNotZero(),
            'seats' => fake()->numberBetween($int1 = 2, $int2 = 600),
        ];
    }
}
