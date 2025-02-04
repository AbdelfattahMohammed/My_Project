<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidate;

class CandidateSeeder extends Seeder
{
    public function run()
    {
        Candidate::factory()->count(10)->create(); // Adjust the count as needed
    }
}
