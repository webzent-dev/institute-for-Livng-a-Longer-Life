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
            $table->string('sku')->nullable()->after('user_id'); // Add SKU field as nullable first
        });
        
        // Update existing records with unique SKUs
        \DB::statement("UPDATE products SET sku = CONCAT('SKU-', id) WHERE sku IS NULL OR sku = ''");
        
        // Now add the unique constraint
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sku');
        });
    }
};
