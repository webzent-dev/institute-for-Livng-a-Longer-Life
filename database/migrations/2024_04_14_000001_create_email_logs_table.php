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
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_email');
            $table->string('recipient_type')->nullable(); // user, collaborator, custom
            $table->unsignedBigInteger('recipient_id')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('email_type'); // collaborator_active, collaborator_login, member_signup, order_confirmation, custom
            $table->string('status')->default('pending'); // pending, sent, failed
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['recipient_email', 'status']);
            $table->index(['email_type', 'status']);
            $table->index('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
