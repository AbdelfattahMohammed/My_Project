<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(['job_posted', 'application_received']),
            'message' => $this->faker->sentence(),
            'read' => false,
        ];
    }
}

