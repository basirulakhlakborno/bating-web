<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialLinkAdminController extends Controller
{
    public function index(): View
    {
        $links = SocialLink::query()->orderBy('sort_order')->get();

        return view('admin.social-links.index', compact('links'));
    }

    public function create(): View
    {
        return view('admin.social-links.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'icon_path' => ['nullable', 'string', 'max:512'],
            'url' => ['required', 'string', 'max:512'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        SocialLink::create($data);

        return redirect()->route('admin.social-links.index')->with('status', 'Social link added.');
    }

    public function edit(SocialLink $socialLink): View
    {
        return view('admin.social-links.edit', ['link' => $socialLink]);
    }

    public function update(Request $request, SocialLink $socialLink): RedirectResponse
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'icon_path' => ['nullable', 'string', 'max:512'],
            'url' => ['required', 'string', 'max:512'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $socialLink->update($data);

        return redirect()->route('admin.social-links.index')->with('status', 'Social link updated.');
    }

    public function destroy(SocialLink $socialLink): RedirectResponse
    {
        $socialLink->delete();

        return redirect()->route('admin.social-links.index')->with('status', 'Social link removed.');
    }
}
