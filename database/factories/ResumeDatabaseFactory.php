<?php

namespace Database\Factories;

use App\Models\ResumeDatabase;
use App\Models\Employer;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResumeDatabaseFactory extends Factory
{
    protected $model = ResumeDatabase::class;

    public function definition()
    {
        return [
            'employer_id' => Employer::inRandomOrder()->first()->id,
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'search_criteria' => json_encode([
                'skills' => $this->faker->words(5),
                'experience_level' => $this->faker->word(),
            ]), // Convert array to JSON string
            'search_date' => now(),
        ];
    }
}



