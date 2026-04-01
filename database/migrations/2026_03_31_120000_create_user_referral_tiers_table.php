<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_referral_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('position');
            $table->string('slug', 32);
            $table->string('label', 191);
            $table->decimal('rate_percent', 6, 2)->default(0);
            $table->decimal('amount', 14, 2)->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'position']);
            $table->index(['user_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_referral_tiers');
    }
};
