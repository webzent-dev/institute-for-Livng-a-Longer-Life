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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('membership_name')->nullable();
            $table->decimal('membership_price', 8, 2);
            $table->string('membership_period')->nullable();
            $table->text('membership_description')->nullable();
            $table->text('membership_features')->nullable();
            $table->text('membership_benefits')->nullable();
            $table->string('popular')->default('no');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
