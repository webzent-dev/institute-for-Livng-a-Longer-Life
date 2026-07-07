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
        Schema::table('sub_orders', function (Blueprint $table) {
            $table->string('shippo_rate_id')->nullable()->after('service_level');
            $table->string('shippo_transaction_id')->nullable()->after('shippo_rate_id');
            $table->text('label_url')->nullable()->after('shippo_transaction_id');
            $table->text('label_pdf_url')->nullable()->after('label_url');
            $table->timestamp('label_created_at')->nullable()->after('label_pdf_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_orders', function (Blueprint $table) {
            $table->dropColumn([
                'shippo_rate_id',
                'shippo_transaction_id',
                'label_url',
                'label_pdf_url',
                'label_created_at',
            ]);
        });
    }
};
