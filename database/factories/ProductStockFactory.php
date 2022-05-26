<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductStock>
 */
class ProductStockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'regular_price' =>$this->faker->numberBetween(2000, 50000),
            'sales_price' => 0,
            'stock_quantity' => $this->faker->numberBetween(10, 100),
            'manage_stock' => true
        ];
    }
}
