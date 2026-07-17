<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vital_boost_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email')->nullable();
            $table->string('product_name')->nullable();
            $table->enum('plan', ['monthly', 'yearly']);
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('membership_percent', 5, 2)->default(0);
            $table->decimal('subscription_percent', 5, 2)->default(0);
            $table->decimal('membership_discount', 10, 2)->default(0);
            $table->decimal('subscription_discount', 10, 2)->default(0);
            // Item total after discounts, before shipping (shipping is recomputed at renewal).
            $table->decimal('item_total', 10, 2)->default(0);
            $table->enum('status', ['active', 'cancelled', 'expired'])->default('active');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('next_billing_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'next_billing_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vital_boost_subscriptions');
    }
};
