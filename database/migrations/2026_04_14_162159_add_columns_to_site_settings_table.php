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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('stripe_sandbox_key')->nullable()->after('session_timeout');
            $table->string('stripe_sandbox_secret')->nullable()->after('stripe_sandbox_key');
            $table->string('stripe_production_key')->nullable()->after('stripe_sandbox_secret');
            $table->string('stripe_production_secret')->nullable()->after('stripe_production_key');
            $table->string('stripe_mode')->default('sandbox')->after('stripe_production_secret');
            $table->string('zoom_client_id')->nullable()->after('stripe_mode');
            $table->string('zoom_client_secret')->nullable()->after('zoom_client_id');
            $table->string('zoom_account_id')->nullable()->after('zoom_client_secret');
            $table->string('zoom_api_url')->nullable()->after('zoom_account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('stripe_sandbox_key');
            $table->dropColumn('stripe_sandbox_secret');
            $table->dropColumn('stripe_production_key');
            $table->dropColumn('stripe_production_secret');
            $table->dropColumn('stripe_mode');
            $table->dropColumn('zoom_client_id');
            $table->dropColumn('zoom_client_secret');
            $table->dropColumn('zoom_account_id');
            $table->dropColumn('zoom_api_url');
        });
    }
};
