<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->longText('site_description')->nullable();
            $table->string('contact_email');
            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->nullable();
            $table->timestamps();
        });
    }

     
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};