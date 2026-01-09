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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('duration')->nullable();
            $table->string('instructor')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('video_file')->nullable(); 
            $table->string('video_url')->nullable();  
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
