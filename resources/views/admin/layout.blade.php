<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>@yield('title', 'Dashboard') &mdash; {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.34.1/dist/tabler-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <style>
        :root {
            --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --tblr-body-bg: #f4f6fb;
        }
        body { font-family: var(--tblr-font-sans-serif); background: var(--tblr-body-bg); }
        .nav-link-title { white-space: nowrap; }
        .sidebar-label { font-size: .625rem; letter-spacing: .06em; text-transform: uppercase; color: rgba(255,255,255,.35); padding: .5rem 1rem .25rem; margin-top: .25rem; }
        .page-pretitle { font-size: .625rem; text-transform: uppercase; letter-spacing: .08em; color: #8a92a6; font-weight: 600; }
        .page-title { font-weight: 700; letter-spacing: -.01em; }

        .card { border: none; border-radius: .75rem; box-shadow: 0 1px 4px rgba(0,0,0,.04); transition: box-shadow .2s ease, transform .15s ease; }
        .card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }
        .card-header { border-bottom: 1px solid rgba(0,0,0,.04); background: transparent; }
        .card-footer { border-top: 1px solid rgba(0,0,0,.04); background: transparent; }
        .card-table { border: none; }
        .card-table thead th { border-bottom-color: rgba(0,0,0,.06); font-weight: 600; text-transform: uppercase; font-size: .7rem; letter-spacing: .04em; color: #8a92a6; }
        .card-table tbody td { border-bottom-color: rgba(0,0,0,.03); }
        .card-table tbody tr:last-child td { border-bottom: none; }

        .table { --tblr-table-striped-bg: transparent; }
        .table-striped > tbody > tr:nth-of-type(odd) > * { --tblr-table-striped-bg: transparent; }

        .btn { border-radius: .5rem; font-weight: 600; transition: all .15s ease; }
        .btn:active { transform: scale(.97); }
        .btn-primary { box-shadow: 0 2px 8px rgba(32,107,196,.25); }
        .btn-primary:hover { box-shadow: 0 4px 14px rgba(32,107,196,.35); transform: translateY(-1px); }
        .btn-sm { border-radius: .4rem; }
        .btn-ghost-danger { border: none; }

        .badge { font-weight: 600; border-radius: .375rem; padding: .3em .6em; }

        .avatar { border: none; border-radius: .5rem; }

        .form-control, .form-select { border: 1px solid rgba(0,0,0,.08); border-radius: .5rem; transition: border-color .15s ease, box-shadow .15s ease; }
        .form-control:focus, .form-select:focus { border-color: #206bc4; box-shadow: 0 0 0 .2rem rgba(32,107,196,.15); }

        .accordion-item { border: none; }
        .accordion-button { border-radius: 0 !important; font-weight: 600; }
        .accordion-button:not(.collapsed) { background: rgba(32,107,196,.04); color: #206bc4; box-shadow: none; }

        .alert { border: none; border-radius: .75rem; }

        .modal-content { border: none; border-radius: .75rem; overflow: hidden; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .page-body .card { animation: fadeInUp .35s ease both; }
        .page-body .row > [class*="col-"]:nth-child(2) .card { animation-delay: .05s; }
        .page-body .row > [class*="col-"]:nth-child(3) .card { animation-delay: .1s; }
        .page-body .row > [class*="col-"]:nth-child(4) .card { animation-delay: .15s; }
        .page-body .card.mb-4:nth-child(2) { animation-delay: .06s; }
        .page-body .card.mb-4:nth-child(3) { animation-delay: .12s; }

        .page-header { animation: fadeInUp .3s ease both; }

        .navbar-vertical .nav-link { border-radius: .4rem; margin: 1px .5rem; transition: background .15s ease; }
        .navbar-vertical .nav-link:hover { background: rgba(255,255,255,.08); }
        .navbar-vertical .nav-link.active { background: rgba(255,255,255,.12); font-weight: 600; }

        .navbar-brand a { font-weight: 800; letter-spacing: -.02em; }

        .subheader { font-weight: 600; text-transform: uppercase; font-size: .7rem; letter-spacing: .04em; color: #8a92a6; }

        .footer { opacity: .6; }
    </style>
    @stack('styles')
</head>
<body class="border-top-wide border-primary">
<div class="page">
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-expanded="false" aria-controls="sidebar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('static/svg/bb88_logo_animation2.gif') }}" alt="{{ config('app.name') }}" width="140" height="30" style="object-fit:contain;">
                </a>
            </h1>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <span class="nav-link-icon"><i class="ti ti-home-filled"></i></span>
                            <span class="nav-link-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-label">Content</li>

                    <li class="nav-item {{ request()->routeIs('admin.games.*', 'admin.game-categories.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#nav-games" data-bs-toggle="collapse" data-bs-auto-close="false" role="button" aria-expanded="{{ request()->routeIs('admin.games.*', 'admin.game-categories.*') ? 'true' : 'false' }}">
                            <span class="nav-link-icon"><i class="ti ti-device-gamepad-2-filled"></i></span>
                            <span class="nav-link-title">Games</span>
                        </a>
                        <div class="dropdown-menu {{ request()->routeIs('admin.games.*', 'admin.game-categories.*') ? 'show' : '' }}" id="nav-games">
                            <a class="dropdown-item {{ request()->routeIs('admin.games.*') ? 'active' : '' }}" href="{{ route('admin.games.index') }}">All games</a>
                            <a class="dropdown-item {{ request()->routeIs('admin.game-categories.*') ? 'active' : '' }}" href="{{ route('admin.game-categories.index') }}">Categories</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.home-cricket-matches.*') ? 'active' : '' }}" href="{{ route('admin.home-cricket-matches.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-calendar-event"></i></span>
                            <span class="nav-link-title">Home cricket</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.navigation.*') ? 'active' : '' }}" href="{{ route('admin.navigation.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-layout-list-filled"></i></span>
                            <span class="nav-link-title">Menus</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.footer.*') ? 'active' : '' }}" href="{{ route('admin.footer.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-layout-bottombar-filled"></i></span>
                            <span class="nav-link-title">Footer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}" href="{{ route('admin.media.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-photo-filled"></i></span>
                            <span class="nav-link-title">Media</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.social-links.*') ? 'active' : '' }}" href="{{ route('admin.social-links.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-world-filled"></i></span>
                            <span class="nav-link-title">Social links</span>
                        </a>
                    </li>

                    <li class="sidebar-label">Finance</li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.payment-methods.*') ? 'active' : '' }}" href="{{ route('admin.payment-methods.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-credit-card-filled"></i></span>
                            <span class="nav-link-title">Payment methods</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.deposits.*') ? 'active' : '' }}" href="{{ route('admin.deposits.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-circle-arrow-down-filled"></i></span>
                            <span class="nav-link-title">Deposits</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}" href="{{ route('admin.withdrawals.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-circle-arrow-up-filled"></i></span>
                            <span class="nav-link-title">Withdrawals</span>
                        </a>
                    </li>

                    <li class="sidebar-label">Users</li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-users-group"></i></span>
                            <span class="nav-link-title">Players</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                            <span class="nav-link-icon"><i class="ti ti-mail-filled"></i></span>
                            <span class="nav-link-title">Messages</span>
                        </a>
                    </li>

                    <li class="sidebar-label">System</li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">
                            <span class="nav-link-icon"><i class="ti ti-settings-filled"></i></span>
                            <span class="nav-link-title">Site settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.settings.edit') }}#header-settings">
                            <span class="nav-link-icon"><i class="ti ti-layout-navbar-filled"></i></span>
                            <span class="nav-link-title">Header settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.settings.edit') }}#home-page-settings">
                            <span class="nav-link-icon"><i class="ti ti-home"></i></span>
                            <span class="nav-link-title">Home page copy</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <div class="page-wrapper">
        <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
            <div class="container-xl">
                <div class="navbar-nav flex-row order-md-last ms-auto align-items-center gap-3">
                    <span class="text-secondary small d-none d-xl-inline">{{ auth('admin')->user()?->email }}</span>
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-ghost-secondary btn-sm">
                            <i class="ti ti-logout-2 me-1"></i>Sign out
                        </button>
                    </form>
                </div>
            </div>
        </header>
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row align-items-center">
                    <div class="col-auto">
                        @hasSection('pretitle')
                            <div class="page-pretitle">@yield('pretitle')</div>
                        @endif
                        <h2 class="page-title">@yield('title', 'Dashboard')</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        @yield('actions')
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('status') }}
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="text-center text-secondary small">&copy; {{ date('Y') }} {{ config('app.name') }}</div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js" defer></script>
@stack('scripts')
</body>
</html>
