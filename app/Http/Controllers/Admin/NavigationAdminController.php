<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NavigationAdminController extends Controller
{
    public function index(): View
    {
        $items = NavigationItem::query()
            ->orderBy('placement')
            ->orderBy('drawer_group')
            ->orderBy('sort_order')
            ->get();

        $desktopItems = $items->where('placement', 'desktop_nav');
        $drawerGroups = $items->where('placement', 'drawer')->groupBy('drawer_group');

        return view('admin.navigation.index', compact('desktopItems', 'drawerGroups'));
    }

    public function create(): View
    {
        return view('admin.navigation.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateNav($request);
        NavigationItem::create($data);

        return redirect()->route('admin.navigation.index')->with('status', 'Menu link added.');
    }

    public function edit(NavigationItem $item): View
    {
        return view('admin.navigation.edit', compact('item'));
    }

    public function update(Request $request, NavigationItem $item): RedirectResponse
    {
        $data = $this->validateNav($request);
        $item->update($data);

        return redirect()->route('admin.navigation.index')->with('status', 'Menu link updated.');
    }

    public function destroy(NavigationItem $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('admin.navigation.index')->with('status', 'Menu link removed.');
    }

    private function validateNav(Request $request): array
    {
        $data = $request->validate([
            'label_bn' => ['required', 'string', 'max:255'],
            'label_en' => ['nullable', 'string', 'max:255'],
            'href' => ['required', 'string', 'max:512'],
            'icon_path' => ['nullable', 'string', 'max:512'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'badge_variant' => ['nullable', 'string', 'max:16'],
            'label_class' => ['nullable', 'string', 'max:128'],
            'placement' => ['required', 'string', 'max:32'],
            'drawer_group' => ['nullable', 'string', 'max:32'],
            'drawer_meta_json' => ['nullable', 'string'],
        ]);

        $meta = [];
        if (! empty($data['drawer_meta_json'])) {
            $decoded = json_decode($data['drawer_meta_json'], true);
            $meta = is_array($decoded) ? $decoded : [];
        }
        unset($data['drawer_meta_json']);
        $data['drawer_meta'] = $meta;
        $data['is_active'] = $request->boolean('is_active');
        $data['is_external'] = $request->boolean('is_external');
        $data['has_badge_ui'] = $request->boolean('has_badge_ui');
        $data['show_underline'] = $request->boolean('show_underline');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
