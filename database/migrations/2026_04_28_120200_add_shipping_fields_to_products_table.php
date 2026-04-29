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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight', 8, 2)->default(0)->after('stock_quantity'); // Weight in pounds
            $table->decimal('length', 8, 2)->nullable()->after('weight'); // Length in inches
            $table->decimal('width', 8, 2)->nullable()->after('length'); // Width in inches
            $table->decimal('height', 8, 2)->nullable()->after('width'); // Height in inches
            $table->string('shipping_template')->nullable()->after('height'); // Package template type
            $table->boolean('requires_shipping')->default(true)->after('shipping_template');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'weight',
                'length',
                'width',
                'height',
                'shipping_template',
                'requires_shipping'
            ]);
        });
    }
};
