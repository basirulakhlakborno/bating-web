<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('games') || ! Schema::hasTable('navigation_items')) {
            return;
        }
        if (! Schema::hasColumn('games', 'opens_in_iframe')) {
            return;
        }

        $id = DB::table('games')
            ->where('opens_in_iframe', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->value('id');

        if (! $id) {
            return;
        }

        $href = '/games/play/'.$id;
        DB::table('navigation_items')->where('href', '/crash')->update(['href' => $href]);
    }

    public function down(): void
    {
        // Non-reversible: multiple rows could use /games/play/{id}.
    }
};
