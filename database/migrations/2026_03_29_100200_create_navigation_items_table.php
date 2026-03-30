<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('placement', 32);
            $table->foreignId('parent_id')->nullable()->constrained('navigation_items')->cascadeOnDelete();
            $table->string('label_bn');
            $table->string('label_en')->nullable();
            $table->string('href', 512);
            $table->string('icon_path', 512)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('show_underline')->default(false);
            $table->string('badge_label')->nullable();
            $table->string('badge_variant', 16)->default('dot');
            $table->string('label_class', 128)->nullable();
            $table->boolean('has_badge_ui')->default(false);
            $table->boolean('is_external')->default(false);
            $table->json('drawer_meta')->nullable();
            $table->string('drawer_group', 32)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_items');
    }
};
