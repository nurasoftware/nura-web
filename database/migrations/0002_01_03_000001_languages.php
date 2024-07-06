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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('code', 25);
            $table->string('locale', 50)->nullable();
            $table->tinyInteger('is_default')->default(0);
            $table->string('status', 25)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->string('dir', 3)->default('ltr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
