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
        Schema::table('orders', function (Blueprint $table) {
            // Snapshot of the buyer's membership plan name at checkout, so the
            // membership discount label stays accurate even if the member later
            // changes or loses their plan.
            $table->string('membership_plan_name')->nullable()->after('membership_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('membership_plan_name');
        });
    }
};
