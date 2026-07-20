<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Record who performed an action, not just who it happened to.
     *
     * audit_logs.user_id is the subject. When an admin acts on a member's behalf
     * the subject is the member, so without an actor column there is no way to
     * tell a member's own action from an admin's.
     */
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('audit_logs', 'actor_id')) {
                $table->foreignId('actor_id')->nullable()->after('user_id')
                    ->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('audit_logs', 'description')) {
                $table->text('description')->nullable()->after('resource_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            if (Schema::hasColumn('audit_logs', 'actor_id')) {
                $table->dropForeign(['actor_id']);
                $table->dropColumn('actor_id');
            }

            if (Schema::hasColumn('audit_logs', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
