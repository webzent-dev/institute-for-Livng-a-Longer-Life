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
        Schema::create('zoom_session_recorded_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zoom_session_table_id')->nullable()->comment = "id of zoom_sessions table";
            $table->foreign('zoom_session_table_id')->references('id')->on('zoom_sessions')->onDelete('cascade');
            $table->text('recorded_link')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_session_recorded_links');
    }
};
