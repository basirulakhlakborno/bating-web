<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        /** @var Game $game */
        $game = Game::query()->create($data);
        $this->syncIframePlayHref($game);

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
        $game->refresh();
        $this->syncIframePlayHref($game);

        return redirect()->route('admin.games.index')->with('status', 'Game updated.');
    }

    public function destroy(Game $game): RedirectResponse
    {
        $this->deleteStoredThumbnail($game->thumbnail_path);
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
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,gif,webp', 'max:4096'],
            'remove_thumbnail' => ['nullable', 'boolean'],
            'href' => ['nullable', 'string', 'max:512'],
            'opens_in_iframe' => ['nullable', 'boolean'],
            'iframe_remote_base' => ['nullable', 'string', 'max:512'],
            'iframe_bridge_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['opens_in_iframe'] = $request->boolean('opens_in_iframe');
        $trimRemote = trim((string) ($data['iframe_remote_base'] ?? ''));
        $data['iframe_remote_base'] = $trimRemote !== '' ? rtrim($trimRemote, '/') : null;
        $trimBridge = trim((string) ($data['iframe_bridge_path'] ?? ''));
        $data['iframe_bridge_path'] = $trimBridge !== '' ? $trimBridge : null;
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        unset($data['thumbnail'], $data['remove_thumbnail']);

        if ($request->hasFile('thumbnail')) {
            if ($game !== null) {
                $this->deleteStoredThumbnail($game->thumbnail_path);
            }
            $stored = $request->file('thumbnail')->store('game-thumbnails', 'public');
            $data['thumbnail_path'] = '/storage/'.$stored;
        } elseif ($request->boolean('remove_thumbnail') && $game !== null) {
            $this->deleteStoredThumbnail($game->thumbnail_path);
            $data['thumbnail_path'] = null;
        } else {
            $trimmed = trim((string) ($request->input('thumbnail_path') ?? ''));
            if ($trimmed === '' && $game !== null && ! $request->boolean('remove_thumbnail')) {
                $data['thumbnail_path'] = $game->thumbnail_path;
            } else {
                $data['thumbnail_path'] = $trimmed !== '' ? $trimmed : null;
            }
        }

        return $data;
    }

    /**
     * Iframe titles always open at /games/play/{id} on this app (token bridge loads inside the frame).
     */
    private function syncIframePlayHref(Game $game): void
    {
        if (! $game->opens_in_iframe) {
            return;
        }
        $expected = '/games/play/'.$game->id;
        if ($game->href !== $expected) {
            $game->forceFill(['href' => $expected])->save();
        }
    }

    private function deleteStoredThumbnail(?string $path): void
    {
        if ($path === null || $path === '') {
            return;
        }
        if (! str_starts_with($path, '/storage/')) {
            return;
        }
        $relative = ltrim(substr($path, strlen('/storage/')), '/');
        if ($relative !== '') {
            Storage::disk('public')->delete($relative);
        }
    }
}
