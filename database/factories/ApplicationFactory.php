<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\Posting;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition()
    {
        return [
            'job_id' => Posting::inRandomOrder()->first()->id,
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'resume' => $this->faker->filePath(),
            'cover_letter' => $this->faker->paragraph(),
            'status' => 'pending',
            'applied_at' => now(),
        ];
    }
}


