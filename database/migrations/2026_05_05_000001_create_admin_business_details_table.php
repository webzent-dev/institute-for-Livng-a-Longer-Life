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
        Schema::create('admin_business_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name');
            $table->string('business_type');
            $table->text('business_address');
            $table->string('business_city');
            $table->string('business_state');
            $table->string('business_zip_code');
            $table->string('business_country');
            $table->string('business_phone');
            $table->string('business_email');
            $table->string('business_website')->nullable();
            $table->text('business_description')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('ein_number')->nullable();
            $table->timestamps();
            
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_business_details');
    }
};
