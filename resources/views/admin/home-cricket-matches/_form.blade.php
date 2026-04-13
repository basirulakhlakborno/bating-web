@php
    $m = $match ?? null;
    $starts = old('match_starts_at', $m?->match_starts_at?->format('Y-m-d\TH:i'));
@endphp

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="upcoming" @selected(old('status', $m?->status ?? 'upcoming') === 'upcoming')>Upcoming</option>
            <option value="live" @selected(old('status', $m?->status) === 'live')>Live</option>
        </select>
    </div>
    <div class="col-md-8">
        <label class="form-label">Innings label <span class="text-secondary">(live only, e.g. 2nd Innings)</span></label>
        <input type="text" name="innings_label" class="form-control" value="{{ old('innings_label', $m?->innings_label) }}" maxlength="128" placeholder="2nd Innings">
    </div>
    <div class="col-12">
        <label class="form-label">League / competition</label>
        <input type="text" name="league_name" class="form-control" value="{{ old('league_name', $m?->league_name) }}" required maxlength="255">
    </div>
    <div class="col-md-6">
        <label class="form-label">Match start (local time)</label>
        <input type="datetime-local" name="match_starts_at" class="form-control" value="{{ $starts }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Sort order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $m?->sort_order ?? 0) }}" min="0">
    </div>
    <div class="col-12">
        <label class="form-label">Card link <span class="text-secondary">(optional)</span></label>
        <input type="text" name="link_url" class="form-control" value="{{ old('link_url', $m?->link_url) }}" maxlength="512" placeholder="/cricket or https://…">
    </div>
</div>

<hr class="my-4"/>

<h3 class="h4 mb-3">Team 1</h3>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name</label>
        <input type="text" name="team1_name" class="form-control" value="{{ old('team1_name', $m?->team1_name) }}" required maxlength="255">
    </div>
    <div class="col-md-6">
        <label class="form-label">Logo URL or path</label>
        <input type="text" name="team1_logo_path" class="form-control" value="{{ old('team1_logo_path', $m?->team1_logo_path) }}" maxlength="512" placeholder="https://… or /storage/…">
    </div>
    <div class="col-md-4">
        <label class="form-label">Score <span class="text-secondary">(live)</span></label>
        <input type="text" name="team1_score" class="form-control" value="{{ old('team1_score', $m?->team1_score) }}" maxlength="32" placeholder="268">
    </div>
    <div class="col-md-4">
        <label class="form-label">Overs</label>
        <input type="text" name="team1_overs" class="form-control" value="{{ old('team1_overs', $m?->team1_overs) }}" maxlength="32" placeholder="/ 10 (50)">
    </div>
</div>

<hr class="my-4"/>

<h3 class="h4 mb-3">Team 2</h3>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name</label>
        <input type="text" name="team2_name" class="form-control" value="{{ old('team2_name', $m?->team2_name) }}" required maxlength="255">
    </div>
    <div class="col-md-6">
        <label class="form-label">Logo URL or path</label>
        <input type="text" name="team2_logo_path" class="form-control" value="{{ old('team2_logo_path', $m?->team2_logo_path) }}" maxlength="512" placeholder="https://… or /storage/…">
    </div>
    <div class="col-md-4">
        <label class="form-label">Score <span class="text-secondary">(live)</span></label>
        <input type="text" name="team2_score" class="form-control" value="{{ old('team2_score', $m?->team2_score) }}" maxlength="32">
    </div>
    <div class="col-md-4">
        <label class="form-label">Overs</label>
        <input type="text" name="team2_overs" class="form-control" value="{{ old('team2_overs', $m?->team2_overs) }}" maxlength="32">
    </div>
</div>

<div class="form-check mt-4">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="hcm_active" @checked(old('is_active', $m?->is_active ?? true))>
    <label class="form-check-label" for="hcm_active">Visible on homepage</label>
</div>
