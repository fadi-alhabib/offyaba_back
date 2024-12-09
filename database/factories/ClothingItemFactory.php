<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClothingItem>
 */
class ClothingItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private array $targetGroups = ['Men', 'Women', 'Children', 'BB'];
    private array $materials = ['Cotton', 'Polyester', 'Jeans'];

    public function definition(): array
    {
        return [
            'type_id' => rand(1, 5),
            'target_group' => $this->targetGroups[rand(0, 3)],
            'material' => $this->materials[rand(0, 2)],
            'sizes' => json_encode(['M', 'L', 'XL', 'XXL', 'S']),
            'colors' => json_encode(['Red', 'Green', 'Blue', 'White', 'Orange']),
        ];
    }
}
