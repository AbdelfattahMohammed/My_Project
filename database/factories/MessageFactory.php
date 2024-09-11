<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Posting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            //
            'sender_id' => User::inRandomOrder()->first()->id,
            'receiver_id' => User::inRandomOrder()->first()->id,
            'job_id' => Posting::inRandomOrder()->first()->id,
            'message' => $this->faker->paragraph(),
            'sent_at' => now(),
        ];
    }
}
