<?php

namespace Database\Factories;

use App\Models\Entry;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
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
            'topic_id' => function(){
                return Topic::all()->random()->id;
            },
            'user_id' => function(){
                return User::all()->random()->id;
            },
            'published' => true,
            'sticky' => $this->faker->numberBetween(0, 1)
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Entry $entry) {
            $url = 'https://source.unsplash.com/random/1200x800';
            $entry
                ->addMediaFromUrl($url)
                ->toMediaCollection('featured_image');
        });
    }
}
