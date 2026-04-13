<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaAsset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaAssetAdminController extends Controller
{
    public function index(): View
    {
        $assets = MediaAsset::query()->orderBy('category')->orderBy('sort_order')->get();
        $grouped = $assets->groupBy('category');

        return view('admin.media.index', compact('grouped'));
    }

    public function create(): View
    {
        $categories = MediaAsset::query()->distinct()->pluck('category')->filter()->sort()->values();

        return view('admin.media.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', 'unique:media_assets,slug'],
            'path' => ['required', 'string', 'max:512'],
            'alt' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:64'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        MediaAsset::create($data);

        return redirect()->route('admin.media.index')->with('status', 'Media item added.');
    }

    public function edit(MediaAsset $medium): View
    {
        $categories = MediaAsset::query()->distinct()->pluck('category')->filter()->sort()->values();

        return view('admin.media.edit', ['asset' => $medium, 'categories' => $categories]);
    }

    public function update(Request $request, MediaAsset $medium): RedirectResponse
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', 'unique:media_assets,slug,' . $medium->id],
            'path' => ['required', 'string', 'max:512'],
            'alt' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:64'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $medium->update($data);

        return redirect()->route('admin.media.index')->with('status', 'Media item updated.');
    }

    public function destroy(MediaAsset $medium): RedirectResponse
    {
        $medium->delete();

        return redirect()->route('admin.media.index')->with('status', 'Media item removed.');
    }
}
