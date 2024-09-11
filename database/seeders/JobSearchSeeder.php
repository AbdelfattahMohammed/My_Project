<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobSearch;

class JobSearchSeeder extends Seeder
{
    public function run()
    {
        JobSearch::factory(10)->create();
    }
}

