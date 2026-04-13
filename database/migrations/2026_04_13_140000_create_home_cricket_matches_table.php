<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_cricket_matches', function (Blueprint $table) {
            $table->id();
            $table->string('status', 16);
            $table->string('innings_label', 128)->nullable();
            $table->string('league_name');
            $table->dateTime('match_starts_at');
            $table->string('team1_name');
            $table->string('team1_logo_path', 512)->nullable();
            $table->string('team1_score', 32)->nullable();
            $table->string('team1_overs', 32)->nullable();
            $table->string('team2_name');
            $table->string('team2_logo_path', 512)->nullable();
            $table->string('team2_score', 32)->nullable();
            $table->string('team2_overs', 32)->nullable();
            $table->string('link_url', 512)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_cricket_matches');
    }
};
