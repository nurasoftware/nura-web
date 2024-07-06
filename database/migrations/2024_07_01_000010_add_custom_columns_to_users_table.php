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
            $table->string('role', 25)
                ->after('email')
                ->default('user');
         
            $table->string('avatar', 200)
                ->after('username')
                ->nullable();

            $table->timestamp('last_activity_at')
                ->after('avatar')
                ->nullable();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'last_activity_at', 'deleted_at']);
        });
    }
};
