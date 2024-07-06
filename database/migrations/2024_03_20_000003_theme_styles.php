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
        Schema::create('theme_styles', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->string('text_color', 20)->nullable();
            $table->string('text_size', 20)->nullable();
            $table->string('title_size', 20)->nullable();
            $table->string('subtitle_size', 20)->nullable();
            $table->string('title_font_weight', 20)->nullable();
            $table->string('subtitle_font_weight', 20)->nullable();
            $table->string('text_font_weight', 20)->nullable();
            $table->string('text_align', 20)->nullable();
            $table->string('link_color', 20)->nullable();
            $table->string('link_hover_color', 20)->nullable();
            $table->string('link_underline_color', 20)->nullable();
            $table->string('link_underline_color_hover', 20)->nullable();
            $table->string('link_decoration', 20)->nullable();
            $table->string('link_hover_decoration', 20)->nullable();
            $table->string('link_font_weight', 20)->nullable();
            $table->string('link_underline_thickness', 20)->nullable();
            $table->string('link_underline_offset', 20)->nullable();
            $table->string('font_family', 100)->nullable();
            $table->string('font_family_weights', 100)->nullable();
            $table->string('bg_color', 20)->nullable();
            $table->string('caption_size', 20)->nullable();
            $table->string('caption_color', 20)->nullable();
            $table->string('caption_style', 20)->default('normal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_styles');
    }
};
