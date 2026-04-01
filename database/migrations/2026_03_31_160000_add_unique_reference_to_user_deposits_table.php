<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Idempotency: same gateway reference cannot credit twice for one user.
     * Multiple NULL references remain allowed (manual / legacy rows).
     */
    public function up(): void
    {
        Schema::table('user_deposits', function (Blueprint $table) {
            $table->unique(['user_id', 'reference'], 'user_deposits_user_reference_unique');
        });
    }

    public function down(): void
    {
        Schema::table('user_deposits', function (Blueprint $table) {
            $table->dropUnique('user_deposits_user_reference_unique');
        });
    }
};
