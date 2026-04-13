<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Sign in &mdash; {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.34.1/dist/tabler-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <style>
        :root { --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; --tblr-body-bg: #f4f6fb; }
        body { font-family: var(--tblr-font-sans-serif); background: var(--tblr-body-bg); }
        .card { border: none; border-radius: .75rem; box-shadow: 0 4px 24px rgba(0,0,0,.06); }
        .card-title { font-weight: 700; }
        .form-control { border: 1px solid rgba(0,0,0,.08); border-radius: .5rem; }
        .form-control:focus { border-color: #206bc4; box-shadow: 0 0 0 .2rem rgba(32,107,196,.15); }
        .btn { border-radius: .5rem; font-weight: 600; }
        .btn-primary { box-shadow: 0 2px 8px rgba(32,107,196,.25); }
        .navbar-brand { font-weight: 800; letter-spacing: -.02em; }
        @keyframes fadeIn { from { opacity:0; transform: translateY(16px); } to { opacity:1; transform: translateY(0); } }
        .card-md { animation: fadeIn .4s ease both; }
    </style>
</head>
<body class="d-flex flex-column border-top-wide border-primary">
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ route('admin.login') }}" class="navbar-brand navbar-brand-autodark">
                <img src="{{ asset('static/svg/bb88_logo_animation2.gif') }}" alt="{{ config('app.name') }}" width="215" height="45" style="object-fit:contain;">
            </a>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Sign in to your account</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.login.store') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <div class="input-icon">
                            <span class="input-icon-addon"><i class="ti ti-mail-filled"></i></span>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required autocomplete="username" autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-icon">
                            <span class="input-icon-addon"><i class="ti ti-lock-filled"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Your password" required autocomplete="current-password">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" name="remember" value="1" class="form-check-input">
                            <span class="form-check-label">Remember me on this device</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-login-2 me-2"></i>Sign in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js" defer></script>
</body>
</html>
