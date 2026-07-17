<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Opt-in: existing members never agreed to be charged automatically,
            // so auto-renewal stays off until they turn it on themselves.
            $table->boolean('auto_renew')->default(false)->after('plan_expiry');

            // Set when a member cancels. They keep their benefits until plan_expiry;
            // this only stops the next automatic charge.
            $table->timestamp('membership_cancelled_at')->nullable()->after('auto_renew');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['auto_renew', 'membership_cancelled_at']);
        });
    }
};
