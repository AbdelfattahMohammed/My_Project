<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employer;
use App\Models\User;

class EmployerFactory extends Factory
{
    protected $model = Employer::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, // Create a new user for the employer
            'company_name' => $this->faker->company,
            'company_logo' => $this->faker->imageUrl(),
            'company_description' => $this->faker->text,
            'website' => $this->faker->url,
        ];
    }
}
