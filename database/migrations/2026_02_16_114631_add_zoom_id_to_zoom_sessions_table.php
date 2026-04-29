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
        Schema::table('zoom_sessions', function (Blueprint $table) {
            $table->string('zoom_id')->nullable()->after('meeting_link');
            $table->longtext('meeting_response')->nullable()->after('zoom_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zoom_sessions', function (Blueprint $table) {
            $table->dropColumn('zoom_id');
            $table->dropColumn('meeting_response');
        });
    }
};
