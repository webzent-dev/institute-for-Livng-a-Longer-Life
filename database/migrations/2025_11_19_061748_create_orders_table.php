<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');                         
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('shipping_charge', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);                      
            $table->integer('quantity')->default(1);
            $table->enum('payment_method', ['cod', 'card', 'upi', 'wallet'])->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])
                ->default('pending');
            $table->enum('order_status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
                'returned'
            ])->default('pending');

            $table->string('shipping_address')->nullable();
            $table->string('billing_address')->nullable();

            $table->timestamp('order_date')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->string('notes')->nullable();

            $table->timestamps();

        });
    }

     
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
