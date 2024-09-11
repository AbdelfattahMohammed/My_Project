<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employer;

class EmployerSeeder extends Seeder
{
    public function run()
    {
        Employer::factory()->count(10)->create(); // Adjust the count as needed
    }
}
