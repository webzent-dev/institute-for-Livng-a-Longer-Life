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
        Schema::create('become_collaborators', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable(); // Worldwide phone
            $table->text('specialty_area_of_expertise');
            $table->string('professional_credentials');
            $table->integer('experience'); // Years as integer
            $table->string('practice_organization');
            $table->string('website_url')->nullable();
            $table->text('description'); // Up to 2000 chars
            $table->boolean('status')->default(false);
            $table->string('role')->default('collaborator'); // Default role
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('become_collaborators');
    }
};
