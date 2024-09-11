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
        Schema::create('postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('responsibilities');
            $table->text('required_skills');
            $table->text('qualifications');
            $table->string('salary_range')->nullable();
            $table->text('benefits')->nullable();
            $table->string('location')->nullable();
            $table->enum('work_type', ['remote', 'on-site', 'hybrid']);
            $table->date('application_deadline');
            $table->string('image')->nullable();
            $table->enum('status', ['accepted', 'refused'])->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postings');
    }
};
