<?php

namespace Database\Factories;

use App\Models\Employer;
use App\Models\Posting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Postings>
 */
class PostingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Posting::class;

    public function definition(): array
    {
        return [
            //
            'employer_id' => Employer::inRandomOrder()->first()->id,
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'responsibilities' => $this->faker->paragraph,
            'required_skills' => $this->faker->sentence,
            'qualifications' => $this->faker->sentence,
            'salary_range' => $this->faker->optional()->randomElement(['50k-60k', '60k-70k', '70k-80k']),
            'benefits' => $this->faker->optional()->text,
            'location' => $this->faker->city,
            'work_type' => $this->faker->randomElement(['remote', 'on-site', 'hybrid']),
            'application_deadline' => $this->faker->date,
            'status' => 'pending',
            'posted_at' => now(),
        ];
    }
}
