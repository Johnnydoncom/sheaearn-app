<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = Country::where('name', 'nigeria')->first();
        $state = $country->states()->whereHas('cities')->inRandomOrder()->first();
        $city = $state->cities()->inRandomOrder()->first();
        return [
            'first_name' => $this->faker->firstName(),
            'last_name'  => $this->faker->lastName(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'user_id' => function() {
                return User::all()->random()->id;
            },
            'country_id' => $country->id,
            'state_id' => $state->id,
            'city_id' => $city->id
        ];
    }
}
