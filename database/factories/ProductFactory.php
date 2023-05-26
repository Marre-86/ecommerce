<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(15),
            'description' => fake()->text(),
            'category_id' => fake()->randomDigitNot(0),
            'price' => fake()->randomFloat(2),
            'weight' => fake()->randomFloat(2),
            'length' => fake()->randomFloat(2),
            'width' => fake()->randomFloat(2),
        ];
    }
}
