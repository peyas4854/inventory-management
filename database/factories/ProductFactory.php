<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'name'        => $this->faker->text(12),
            'price'       => $this->faker->randomFloat( 2, 100,500),
            'image'       => "{$this->faker->image('public/storage/products',640,480, null, false)}",
            'description' => $this->faker->text(300),
            'created_by'  => 1,
        ];
    }
}
