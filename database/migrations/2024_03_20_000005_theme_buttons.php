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
        Schema::create('theme_buttons', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->string('bg_color', 20)->nullable();
            $table->string('font_color', 20)->nullable();
            $table->string('border_color', 20)->nullable();
            $table->string('bg_color_hover', 20)->nullable();
            $table->string('font_color_hover', 20)->nullable();
            $table->string('border_color_hover', 20)->nullable();
            $table->string('shadow', 20)->nullable();
            $table->string('rounded', 20)->nullable();
            $table->string('font_weight', 20)->nullable();
            $table->string('size', 20)->nullable();
            $table->boolean('is_default', 20)->default(false);            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_buttons');
    }
};
