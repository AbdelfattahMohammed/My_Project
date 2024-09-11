<?php

namespace Database\Seeders;

use App\Models\ResumeDatabase;
use Illuminate\Database\Seeder;

class ResumeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ResumeDatabase::factory(10)->create();
    }
}
