<?php

namespace Database\Factories;

use App\Models\JobSearch;
use App\Models\Candidate;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobSearchFactory extends Factory
{
    protected $model = JobSearch::class;

    public function definition()
    {
        return [
            'candidate_id' => Candidate::inRandomOrder()->first()->id,
            'keywords' => $this->faker->words(3, true),
            'location' => $this->faker->city,
            'category' => $this->faker->word,
            'experience_level' => $this->faker->randomElement(['Entry Level', 'Mid Level', 'Senior Level']),
            'salary_range' => $this->faker->randomElement(['$40,000 - $50,000', '$50,000 - $60,000', '$60,000 - $70,000']),
            'date_posted' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'search_date' => now(), // Using current timestamp for search_date
        ];
    }
}


