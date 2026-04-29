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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->comment = "id of users table";
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('transaction_id')->unique()->nullable();
            $table->string('description')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('amount')->nullable();
            $table->json('card_details')->nullable();
            $table->json('invoice_detail')->nullable();
            $table->json('receipt_detail')->nullable();
            $table->string('payment_for')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
