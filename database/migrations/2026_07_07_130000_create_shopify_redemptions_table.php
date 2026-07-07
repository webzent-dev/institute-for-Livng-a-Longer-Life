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
        Schema::create('shopify_redemptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('membership_number')->nullable()->index();
            $table->string('discount_code')->nullable();
            $table->string('shopify_order_id')->nullable();
            $table->decimal('order_amount', 10, 2)->nullable();
            $table->string('currency', 10)->nullable();
            $table->timestamp('redeemed_at')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopify_redemptions');
    }
};
