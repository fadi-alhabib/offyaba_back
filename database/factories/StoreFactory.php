<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'section_id' => rand(1, 5),
            'name' => fake()->name,
            'address' => fake()->streetAddress,
            'latitude' => fake()->randomFloat(10, 30, 33),
            'longitude' => fake()->randomFloat(10, 30, 33),
            'discount' => rand(1, 20)
        ];
    }
}
