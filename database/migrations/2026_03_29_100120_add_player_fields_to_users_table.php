<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 64)->nullable()->unique()->after('name');
            $table->string('phone', 32)->nullable()->after('email');
            $table->string('currency_code', 8)->default('BDT')->after('phone');
            $table->string('locale', 16)->default('bn')->after('currency_code');
            $table->string('role', 32)->default('user')->after('locale');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'phone', 'currency_code', 'locale', 'role']);
        });
    }
};
