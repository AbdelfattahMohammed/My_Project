<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_searches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->string('keywords')->nullable();
            $table->string('location')->nullable();
            $table->string('category')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('salary_range')->nullable();
            $table->timestamp('date_posted')->nullable();
            $table->timestamp('search_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_searches');
    }
};
