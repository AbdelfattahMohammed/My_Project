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
        Schema::create('post_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('posting_id')->constrained('postings')->onDelete('cascade');
            $table->enum('action_type', ['like', 'comment', 'share']);
            $table->text('comment_text')->nullable(); // Only used if the action is a comment
            $table->enum('platform', ['facebook', 'twitter', 'linkedin', 'email'])->nullable(); // Only used if the action is a share
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_actions');
    }
};
