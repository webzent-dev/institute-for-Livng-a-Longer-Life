<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Null out any orphaned references so the constraint can be applied cleanly.
        DB::table('shopify_redemptions')
            ->whereNotNull('user_id')
            ->whereNotIn('user_id', function ($query) {
                $query->select('id')->from('users');
            })
            ->update(['user_id' => null]);

        Schema::table('shopify_redemptions', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shopify_redemptions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
