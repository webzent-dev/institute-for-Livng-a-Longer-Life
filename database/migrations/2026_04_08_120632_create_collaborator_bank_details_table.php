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
        Schema::create('collaborator_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('account_holder_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('account_type')->nullable(); // checking, savings
            $table->string('swift_code')->nullable();
            $table->string('iban')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('bank_city')->nullable();
            $table->string('bank_state')->nullable();
            $table->string('bank_zip_code')->nullable();
            $table->string('bank_country')->nullable();
            $table->string('beneficiary_address')->nullable();
            $table->string('beneficiary_city')->nullable();
            $table->string('beneficiary_state')->nullable();
            $table->string('beneficiary_zip_code')->nullable();
            $table->string('beneficiary_country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborator_bank_details');
    }
};
