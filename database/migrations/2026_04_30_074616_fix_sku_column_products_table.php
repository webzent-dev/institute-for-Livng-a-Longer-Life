<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only update existing records if SKU column exists
        if (Schema::hasColumn('products', 'sku')) {
            // Update existing records with unique SKUs
            DB::statement("UPDATE products SET sku = CONCAT('SKU-', id) WHERE sku IS NULL OR sku = ''");
            
            // Try to add unique constraint (will fail if already exists, but that's ok)
            try {
                Schema::table('products', function (Blueprint $table) {
                    $table->string('sku')->nullable(false)->change();
                    $table->unique('sku');
                });
            } catch (\Exception $e) {
                // Unique constraint already exists, continue
            }
        } else {
            // Add SKU column if it doesn't exist
            Schema::table('products', function (Blueprint $table) {
                $table->string('sku')->nullable()->after('user_id');
            });
            
            // Update existing records
            DB::statement("UPDATE products SET sku = CONCAT('SKU-', id) WHERE sku IS NULL OR sku = ''");
            
            // Make it NOT NULL and add unique constraint
            Schema::table('products', function (Blueprint $table) {
                $table->string('sku')->nullable(false)->change();
                $table->unique('sku');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->dropColumn('sku');
        });
    }
};
