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
        Schema::create('contact', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_lang_id')->nullable();
            $table->string('name', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->text('subject')->nullable();
            $table->mediumText('message')->nullable();
            $table->string('ip', 50)->nullable();
            $table->string('geo_country', 50)->nullable();
            $table->string('geo_country_code', 25)->nullable();
            $table->string('geo_city', 100)->nullable();
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->tinyInteger('is_important')->default(0);
            
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact');
    }
};