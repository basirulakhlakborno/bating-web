<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterItem;
use App\Models\FooterSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FooterAdminController extends Controller
{
    public function index(): View
    {
        $sections = FooterSection::query()
            ->where('slug', '!=', 'ambassadors')
            ->with(['items'])
            ->orderBy('sort_order')
            ->get();

        return view('admin.footer.index', compact('sections'));
    }

    public function editItem(FooterItem $footerItem): View
    {
        if ($footerItem->section?->slug === 'ambassadors') {
            abort(404);
        }

        return view('admin.footer.edit-item', compact('footerItem'));
    }

    public function updateItem(Request $request, FooterItem $footerItem): RedirectResponse
    {
        if ($footerItem->section?->slug === 'ambassadors') {
            abort(404);
        }

        $footerItem->update($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:512'],
            'link_url' => ['nullable', 'string', 'max:512'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]));

        return redirect()->route('admin.footer.index')->with('status', 'Footer entry updated.');
    }

    public function createItem(FooterSection $section): View
    {
        if ($section->slug === 'ambassadors') {
            abort(404);
        }

        return view('admin.footer.create-item', ['section' => $section]);
    }

    public function storeItem(Request $request, FooterSection $section): RedirectResponse
    {
        if ($section->slug === 'ambassadors') {
            abort(404);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:512'],
            'link_url' => ['nullable', 'string', 'max:512'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $section->items()->create($data);

        return redirect()->route('admin.footer.index')->with('status', 'Footer entry added.');
    }
}
