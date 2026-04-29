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
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');    
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->enum('payment_method', ['cod', 'card', 'upi', 'wallet'])->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);    
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');                  
            //$table->integer('quantity')->default(1);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->json('shipping_address')->nullable();
            $table->json('billing_address')->nullable();
            /*$table->timestamp('order_date')->nullable();
            $table->timestamp('delivered_at')->nullable();*/
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

     
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
