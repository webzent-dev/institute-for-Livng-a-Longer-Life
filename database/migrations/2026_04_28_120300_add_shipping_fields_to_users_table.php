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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('shipping_handling_fee', 8, 2)->default(2.00)->after('collaborator_message');
            $table->string('shipping_package_template')->nullable()->after('shipping_handling_fee');
            $table->text('shipping_instructions')->nullable()->after('shipping_package_template');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_handling_fee',
                'shipping_package_template',
                'shipping_instructions'
            ]);
        });
    }
};
