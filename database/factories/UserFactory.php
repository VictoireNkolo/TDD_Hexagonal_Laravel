<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    /**
     * @return array|void
     */
    public function definition()
    {
        return [
            'name'                =>  fake()->name(),
            'email'               =>  fake()->email(),
            'role'                =>  fake()->randomElement(['admin', 'user']),
            'email_verified_at'   =>  now(),
            'password'            =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'      =>  Str::random(10),
        ];
    }

}
