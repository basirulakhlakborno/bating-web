<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GameAdminController extends Controller
{
    public function index(): View
    {
        $games = Game::query()->with('category')->orderBy('sort_order')->get();

        return view('admin.games.index', compact('games'));
    }

    public function create(): View
    {
        $categories = GameCategory::query()->orderBy('sort_order')->get();

        return view('admin.games.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, null);
        Game::query()->create($data);

        return redirect()->route('admin.games.index')->with('status', 'Game created.');
    }

    public function edit(Game $game): View
    {
        $categories = GameCategory::query()->orderBy('sort_order')->get();

        return view('admin.games.edit', compact('game', 'categories'));
    }

    public function update(Request $request, Game $game): RedirectResponse
    {
        $game->update($this->validated($request, $game));

        return redirect()->route('admin.games.index')->with('status', 'Game updated.');
    }

    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        return redirect()->route('admin.games.index')->with('status', 'Game deleted.');
    }

    protected function validated(Request $request, ?Game $game): array
    {
        $slugRule = Rule::unique('games', 'slug');
        if ($game) {
            $slugRule = $slugRule->ignore($game->id);
        }

        $data = $request->validate([
            'game_category_id' => ['required', 'exists:game_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $slugRule],
            'provider' => ['nullable', 'string', 'max:255'],
            'thumbnail_path' => ['nullable', 'string', 'max:512'],
            'href' => ['nullable', 'string', 'max:512'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
