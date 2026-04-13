<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeCricketMatch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HomeCricketMatchAdminController extends Controller
{
    public function index(): View
    {
        $matches = HomeCricketMatch::query()->orderBy('sort_order')->orderBy('match_starts_at')->get();

        return view('admin.home-cricket-matches.index', compact('matches'));
    }

    public function create(): View
    {
        return view('admin.home-cricket-matches.create');
    }

    public function store(Request $request): RedirectResponse
    {
        HomeCricketMatch::query()->create($this->validated($request));

        return redirect()->route('admin.home-cricket-matches.index')->with('status', 'Match highlight created.');
    }

    public function edit(HomeCricketMatch $home_cricket_match): View
    {
        return view('admin.home-cricket-matches.edit', ['match' => $home_cricket_match]);
    }

    public function update(Request $request, HomeCricketMatch $home_cricket_match): RedirectResponse
    {
        $home_cricket_match->update($this->validated($request));

        return redirect()->route('admin.home-cricket-matches.index')->with('status', 'Match highlight updated.');
    }

    public function destroy(HomeCricketMatch $home_cricket_match): RedirectResponse
    {
        $home_cricket_match->delete();

        return redirect()->route('admin.home-cricket-matches.index')->with('status', 'Match highlight deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['live', 'upcoming'])],
            'innings_label' => ['nullable', 'string', 'max:128'],
            'league_name' => ['required', 'string', 'max:255'],
            'match_starts_at' => ['required', 'date'],
            'team1_name' => ['required', 'string', 'max:255'],
            'team1_logo_path' => ['nullable', 'string', 'max:512'],
            'team1_score' => ['nullable', 'string', 'max:32'],
            'team1_overs' => ['nullable', 'string', 'max:32'],
            'team2_name' => ['required', 'string', 'max:255'],
            'team2_logo_path' => ['nullable', 'string', 'max:512'],
            'team2_score' => ['nullable', 'string', 'max:32'],
            'team2_overs' => ['nullable', 'string', 'max:32'],
            'link_url' => ['nullable', 'string', 'max:512'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        foreach (['innings_label', 'team1_logo_path', 'team1_score', 'team1_overs', 'team2_logo_path', 'team2_score', 'team2_overs', 'link_url'] as $nullable) {
            if (array_key_exists($nullable, $data) && $data[$nullable] === '') {
                $data[$nullable] = null;
            }
        }

        return $data;
    }
}
