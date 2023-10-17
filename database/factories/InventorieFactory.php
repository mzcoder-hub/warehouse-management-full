<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventorie>
 */
class InventorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'p-' . $this->faker->unique()->numberBetween(1, 100),
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100000, 350000),
            'stock' => $this->faker->numberBetween(1, 20)
        ];
    }
}
