<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameCategoryAdminController extends Controller
{
    public function index(): View
    {
        $categories = GameCategory::withCount('games')->orderBy('sort_order')->get();

        return view('admin.game-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.game-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:64', 'unique:game_categories,slug'],
            'name_bn' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        GameCategory::create($data);

        return redirect()->route('admin.game-categories.index')->with('status', 'Game type added.');
    }

    public function edit(GameCategory $gameCategory): View
    {
        return view('admin.game-categories.edit', ['category' => $gameCategory]);
    }

    public function update(Request $request, GameCategory $gameCategory): RedirectResponse
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:64', 'unique:game_categories,slug,' . $gameCategory->id],
            'name_bn' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $gameCategory->update($data);

        return redirect()->route('admin.game-categories.index')->with('status', 'Game type updated.');
    }

    public function destroy(GameCategory $gameCategory): RedirectResponse
    {
        if ($gameCategory->games()->exists()) {
            return redirect()->route('admin.game-categories.index')
                ->with('status', 'Cannot delete — this type still has games. Move or remove the games first.');
        }

        $gameCategory->delete();

        return redirect()->route('admin.game-categories.index')->with('status', 'Game type removed.');
    }
}
