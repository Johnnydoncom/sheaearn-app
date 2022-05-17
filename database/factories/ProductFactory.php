<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'category_id' => function(){
                return Category::whereNotNull('parent_id')->get()->random()->id;
            },
            'user_id' => function(){
                return User::all()->random()->id;
            },
            'regular_price' =>$this->faker->numberBetween(2000, 50000),
            'sales_price' => 0,
            'manage_stock' => true,
            'stock_quantity' => $this->faker->numberBetween(5, 100),
            'type' => $this->faker->randomElement(['physical', 'digital']),
            'brand_id' => function(){
                return Brand::all()->random()->id;
            },
            'commission' => $this->faker->numberBetween(10, 100)
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $url = 'https://source.unsplash.com/random/1200x800';
            $product
                ->addMediaFromUrl($url)
                ->toMediaCollection('featured_image');
        });
    }
}
