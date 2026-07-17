<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Split the existing single `discount` figure into its parts for reporting.
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('membership_discount', 10, 2)->default(0)->after('discount');
            $table->decimal('subscription_discount', 10, 2)->default(0)->after('membership_discount');
        });

        // Record how each line was purchased.
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('purchase_type')->default('one_time')->after('product_name');
            $table->string('subscription_plan')->nullable()->after('purchase_type');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['membership_discount', 'subscription_discount']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['purchase_type', 'subscription_plan']);
        });
    }
};
