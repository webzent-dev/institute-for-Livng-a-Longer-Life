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
        Schema::create('vital_boost_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section_key', 100)->unique()->comment = 'hero, benefits, booster, usage, cta';
            $table->string('heading')->nullable();
            $table->string('subheading')->nullable();
            $table->longText('body')->nullable();
            $table->json('items')->nullable()->comment = 'repeatable rows: benefit cards, facts, ingredients, bullets';
            $table->json('meta')->nullable()->comment = 'section extras: badge text, prices, button labels';
            $table->string('status', 20)->default('active');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_boost_contents');
    }
};
