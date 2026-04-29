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
        Schema::table('users', function (Blueprint $table) {
            $table->string('plan_name')->after('plan_id')->nullable();
            $table->string('plan_price')->after('plan_name')->nullable();
            $table->string('plan_period')->after('plan_price')->nullable();
            $table->string('plan_expiry')->after('plan_period')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('plan_name');
            $table->dropColumn('plan_price');
            $table->dropColumn('plan_period');
            $table->dropColumn('plan_expiry');
        });
    }
};
