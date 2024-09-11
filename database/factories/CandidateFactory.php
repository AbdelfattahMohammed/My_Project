<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Candidate;
use App\Models\User;

class CandidateFactory extends Factory
{
    protected $model = Candidate::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, // Create a new user for the candidate
            'resume' => $this->faker->word . '.pdf',
            'skills' => $this->faker->words(5, true),
            'experience_level' => $this->faker->word,
            'location' => $this->faker->city,
            'contact_info' => json_encode([
                'phone' => $this->faker->phoneNumber,
                'email' => $this->faker->safeEmail,
            ]),
        ];
    }
}
