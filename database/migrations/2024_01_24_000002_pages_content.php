<?php

/*
 * NuraWeb - Free and Open Source Website Builder
 *
 * Copyright (C) 2024  Chimilevschi Iosif Gabriel, https://nurasoftware.com.
 *
 * LICENSE:
 * NuraWeb is licensed under the GNU General Public License v3.0
 * Permissions of this strong copyleft license are conditioned on making available complete source code 
 * of licensed works and modifications, which include larger works using a licensed work, under the same license. 
 * Copyright and license notices must be preserved. Contributors provide an express grant of patent rights.
 *    
 * @copyright   Copyright (c) 2024, Chimilevschi Iosif Gabriel, https://nurasoftware.com.
 * @license     https://opensource.org/licenses/GPL-3.0  GPL-3.0 License.
 * @author      Chimilevschi Iosif Gabriel <office@nurasoftware.com>
 * 
 * 
 * IMPORTANT: DO NOT edit this file manually. All changes will be lost after software update.
 */

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
        Schema::create('page_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('lang_id')->nullable();
            $table->string('title', 250)->nullable();
            $table->string('slug', 250)->nullable();
            $table->mediumText('meta_title')->nullable();
            $table->mediumText('meta_description')->nullable();

            $table->foreign('page_id')->references('id')->on('pages')->cascadeOnDelete();
            $table->foreign('lang_id')->references('id')->on('languages')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_content');
    }
};