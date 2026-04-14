<?php

use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ensure crash category + Aviator iframe game exist; point /crash nav links at /games/play/{id}.
     */
    public function up(): void
    {
        if (! Schema::hasTable('games') || ! Schema::hasTable('game_categories')) {
            return;
        }
        if (! Schema::hasColumn('games', 'opens_in_iframe')) {
            return;
        }

        $category = GameCategory::query()->firstOrCreate(
            ['slug' => 'crash'],
            [
                'name_bn' => 'ক্র্যাশ',
                'name_en' => 'Crash',
                'sort_order' => 2,
            ]
        );

        $embedBase = rtrim((string) config('services.aviator.public_url', ''), '/');

        $game = Game::query()->firstOrNew(['slug' => 'aviator']);
        $isNew = ! $game->exists;

        $game->game_category_id = $category->id;
        $game->title = 'Aviator';
        $game->slug = 'aviator';
        $game->opens_in_iframe = true;
        $game->iframe_bridge_path = $game->iframe_bridge_path ?: 'game-bridge';
        if ($embedBase !== '') {
            $game->iframe_remote_base = $embedBase;
        }
        $game->is_active = true;
        if ($isNew) {
            $game->provider = null;
            $game->thumbnail_path = '/static/image/logo/logo.webp';
            $game->sort_order = 0;
            $game->is_featured = true;
            $game->href = '/games/play/0';
        }
        $game->save();

        $playHref = '/games/play/'.$game->id;
        if ($game->href !== $playHref) {
            $game->forceFill(['href' => $playHref])->save();
        }

        if (Schema::hasTable('navigation_items')) {
            DB::table('navigation_items')
                ->where('href', '/crash')
                ->update(['href' => $playHref]);
        }
    }

    public function down(): void
    {
        // Intentionally empty: removing Aviator could strand navigation links.
    }
};
