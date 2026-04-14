<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->boolean('opens_in_iframe')->default(false)->after('href');
            $table->string('iframe_remote_base', 512)->nullable()->after('opens_in_iframe');
            $table->string('iframe_bridge_path', 255)->nullable()->after('iframe_remote_base');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['opens_in_iframe', 'iframe_remote_base', 'iframe_bridge_path']);
        });
    }
};
