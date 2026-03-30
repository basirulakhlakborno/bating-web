<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; background: #121212; color: #e0e0e0; line-height: 1.5; }
        a { color: #90caf9; }
        header { background: #1e1e1e; padding: 12px 20px; display: flex; flex-wrap: wrap; gap: 12px 16px; align-items: center; border-bottom: 1px solid #333; }
        header nav { display: flex; flex-wrap: wrap; gap: 12px 16px; align-items: center; }
        main { padding: 24px 20px; max-width: 1200px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #333; padding: 8px 10px; vertical-align: top; }
        th { background: #1a1a1a; }
        input[type=text], input[type=number], input[type=url], textarea, select { width: 100%; max-width: 100%; padding: 8px; background: #1e1e1e; color: #fff; border: 1px solid #444; box-sizing: border-box; }
        textarea { min-height: 120px; font-family: ui-monospace, monospace; font-size: 13px; }
        .btn { display: inline-block; padding: 8px 14px; background: #2e7d32; color: #fff; text-decoration: none; border: none; cursor: pointer; border-radius: 4px; font-size: 14px; }
        .btn-secondary { background: #444; }
        .btn-danger { background: #c62828; }
        .stack { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
        .row-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
        .error { color: #ff8a80; margin: 8px 0; }
    </style>
</head>
<body>
<header>
    <strong>Admin</strong>
    <nav>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.games.index') }}">Games</a>
        <a href="{{ route('admin.navigation.index') }}">Navigation</a>
        <a href="{{ route('admin.footer.index') }}">Footer</a>
        <a href="{{ route('admin.settings.edit') }}">Site settings</a>
        <a href="{{ route('admin.users.index') }}">Users</a>
    </nav>
    <form action="{{ route('logout') }}" method="post" style="margin-left: auto;">
        @csrf
        <button type="submit" class="btn btn-secondary">Logout</button>
    </form>
</header>
<main>
    @if (session('status'))
        <p style="color:#8bc34a;">{{ session('status') }}</p>
    @endif
    @if ($errors->any())
        <ul class="error">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    @endif
    @yield('content')
</main>
</body>
</html>
