<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Section-based CMS copy for the public pages other than Vital Boost
     * (about, collaborators, intro_videos, shop, contact, faq, help_center, testimonials).
     * The editable shape of each page lives in config/page_content.php.
     */
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page_key', 60);
            $table->string('section_key', 60);
            $table->string('heading')->nullable();
            $table->string('subheading')->nullable();
            $table->longText('body')->nullable();
            $table->json('items')->nullable();
            $table->json('meta')->nullable();
            $table->string('status', 20)->default('active');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['page_key', 'section_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
