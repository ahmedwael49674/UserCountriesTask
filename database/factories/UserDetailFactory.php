<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailFactory extends Factory
{
    protected $model = UserDetail::class;

    public function definition(): array
    {
        return [
            'user_id'                   => User::factory(),
            'citizenship_country_id'    => rand(1, 6), //avaiable countries
            'first_name'                => $this->faker->name(),
            'last_name'                 => $this->faker->name(),
            'phone_number'              => $this->faker->phoneNumber(),
        ];
    }
}
