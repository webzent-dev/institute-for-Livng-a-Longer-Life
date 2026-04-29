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
        Schema::create('sub_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('sub_order_number')->unique();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('handling_fee', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->json('origin_address')->nullable(); // Seller's pickup address
            $table->json('destination_address')->nullable(); // Customer shipping address
            $table->string('tracking_number')->nullable();
            $table->string('carrier')->nullable();
            $table->string('service_level')->nullable();
            $table->decimal('weight', 8, 2)->default(0); // Total weight in pounds
            $table->json('package_dimensions')->nullable(); // L x W x H in inches
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'seller_id']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_orders');
    }
};
