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
        Schema::table('users', function (Blueprint $t) {
            $t->enum('role', ['admin','designer','customer'])->default('customer')->after('password');
            $t->string('phone')->nullable();
            $t->string('avatar')->nullable();
            $t->string('whatsapp')->nullable();
            $t->timestamp('last_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
             $t->dropColumn(['role','phone','avatar','whatsapp','last_login_at']);
        });
    }
};
