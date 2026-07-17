<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            // Exclusive member discount for this plan, as a percentage (e.g. 5.00 = 5%).
            $table->decimal('discount_percent', 5, 2)->default(0)->after('membership_price');
        });
    }

    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn('discount_percent');
        });
    }
};
