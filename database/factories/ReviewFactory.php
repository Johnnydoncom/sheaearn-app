<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'review' => $this->faker->paragraph,
            'rating' => $this->faker->numberBetween(1, 5),
            'user_id' => function() {
                return User::all()->random()->id;
            }
        ];
    }
}
