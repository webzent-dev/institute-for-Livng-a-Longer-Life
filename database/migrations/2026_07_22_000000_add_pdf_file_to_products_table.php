<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Guide products are downloadable PDFs rather than physical goods, so they
     * carry the uploaded file name here (stored under storage/app/product_pdfs).
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('pdf_file')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('pdf_file');
        });
    }
};
