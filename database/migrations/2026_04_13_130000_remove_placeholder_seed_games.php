<?php

use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove demo games/categories from the old SiteContentSeeder; keep a single catalog row (e.g. Fortune Gems).
     */
    public function up(): void
    {
        if (! Schema::hasTable('games')) {
            return;
        }

        Game::query()->whereIn('slug', ['super-ace', 'live-baccarat', 'aviator-style'])->delete();

        if (Schema::hasTable('game_categories')) {
            GameCategory::query()
                ->whereIn('slug', ['casino', 'crash', 'cricket'])
                ->whereDoesntHave('games')
                ->delete();
        }
    }
};
