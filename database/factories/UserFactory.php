<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // or use Hash::make('password') in Laravel 9+
            'role' => $this->faker->randomElement(['admin', 'employer', 'candidate']), // or any default role you want to set
            'profile_picture' => $this->faker->imageUrl(),
            'contact_info' => json_encode([
                'phone' => $this->faker->phoneNumber,
                'address' => $this->faker->address,
            ]),
        ];
    }
}
