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
        Schema::create('zoom_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('host')->nullable()->comment = "id of users table";
            $table->foreign('host')->references('id')->on('users');
            //$table->enum('status', ['0', '1'])->default('1')->comment = "1=>'Active',0=>'Inactive'";
            //$table->enum('is_deleted', ['0', '1'])->default('0')->comment = "1=>'Deleted',0=>'Not Deleted'";
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('duration')->nullable();
            $table->text('meeting_link')->nullable();
            //$table->timestamps();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_sessions');
    }
};
