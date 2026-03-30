<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="title" content="{{ $metaTitle ?? 'Babu88 | Your preferred Cricket Exchange | Get your Free ID today' }}">
    <meta name="description" content="{{ $metaDescription ?? 'Register and experience the best Cricket Exchange in Bangladesh with 24/7 Service.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'cricket exchange, best cricket exchange, cricket betting' }}">
    <meta property="og:title" content="{{ $ogTitle ?? 'Babu88 | Premium Cricket Exchange | Online Live Casino Bangladesh' }}">
    <meta property="og:description" content="{{ $ogDescription ?? 'Register and experience the best Cricket Exchange in Bangladesh with 24/7 Service.' }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:site_name" content="Babu88">
    <meta property="og:image" content="{{ $ogImage ?? '/static/image/logo/logo.webp' }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image:alt" content="Babu88">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="bookmark" href="/favicon.ico">
    <title>{{ $title ?? 'Babu88 | Premium Cricket Exchange | Online Live Casino Bangladesh' }}</title>
    {{-- Intercom loads from their CDN on production; stub avoids "Intercom is not a function" on localhost --}}
    <script>
        (function () {
            if (typeof window.Intercom === 'function') return;
            var q = [];
            var stub = function () { q.push(arguments); };
            stub.q = q;
            window.Intercom = stub;
        })();
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons">
    <link rel="preload" href="/css/chunk-vendors.544b9641.css" as="style">
    <link rel="preload" href="/css/app.2e795c71.css" as="style">
    <link rel="stylesheet" href="/css/chunk-vendors.544b9641.css">
    <link rel="stylesheet" href="/css/app.2e795c71.css">
    <link rel="stylesheet" href="/css/chunk-745f18e8.f9f3f906.css">
    <style>
        /* One scroll root only (body). Avoids iOS Safari “two people pulling the rope”. */
        html {
            overflow-x: hidden !important;
            overflow-y: visible !important;
            height: auto !important;
            -webkit-overflow-scrolling: auto;
        }
        body {
            overflow-x: hidden !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-y: auto;
            min-height: 0;
            position: relative;
        }
        #app {
            overflow: visible !important;
            height: auto !important;
            min-height: 0 !important;
        }
        /* Avoid min-height:100vh here — it stretches layout past content and leaves a white gap under the footer (worse on iOS). */
        .v-application--wrap {
            overflow: visible !important;
            min-height: unset !important;
            height: auto !important;
            max-height: none !important;
        }
        .v-application--wrap > div {
            overflow-x: hidden !important;
            overflow-y: visible !important;
            height: auto !important;
            flex: 0 0 auto !important;
            max-height: none !important;
        }
        main { display: block; overflow: visible; }
        /* Animated WoF GIF: own compositor layer so decode/paint does not fight scroll */
        .v-image.v-responsive.wofClass {
            flex-shrink: 0;
            isolation: isolate;
            transform: translateZ(0);
            backface-visibility: hidden;
        }
        @media only screen and (max-width: 959px) {
            .v-application .hidden-sm-and-down { display: none !important; }
        }
        @media only screen and (min-width: 960px) {
            .v-application .hidden-md-and-up { display: none !important; }
        }
        .currency-language-dialog-root {
            position: fixed;
            inset: 0;
            z-index: 1200;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            box-sizing: border-box;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.28s ease, visibility 0.28s ease;
        }
        .currency-language-dialog-root.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }
        .currency-language-dialog-scrim {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.52);
            opacity: 0;
            transition: opacity 0.28s ease;
        }
        .currency-language-dialog-root.is-open .currency-language-dialog-scrim {
            opacity: 1;
        }
        .currency-language-dialog-sheet {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 520px;
            max-height: 90vh;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
            box-shadow: 0 11px 15px -7px rgba(0,0,0,.2), 0 24px 38px 3px rgba(0,0,0,.14), 0 9px 46px 8px rgba(0,0,0,.12);
            opacity: 0;
            transform: scale(0.94) translateY(16px);
            transition: opacity 0.3s cubic-bezier(0.22, 1, 0.36, 1), transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .currency-language-dialog-root.is-open .currency-language-dialog-sheet {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
        @media (prefers-reduced-motion: reduce) {
            .currency-language-dialog-root,
            .currency-language-dialog-scrim,
            .currency-language-dialog-sheet {
                transition-duration: 0.05s !important;
            }
            .currency-language-dialog-sheet {
                transform: none !important;
            }
            .currency-language-dialog-root.is-open .currency-language-dialog-sheet {
                transform: none !important;
            }
        }
        .currency-language-dialog-sheet .dialog-close-icon {
            background-color: #ffce01;
            font-size: xx-large;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            line-height: 1;
            padding: 4px 8px;
        }
        .download-bar-button.v-btn {
            background-color: #EBBE01 !important;
            border-color: #EBBE01 !important;
        }
        .download-bar-button .v-btn__content {
            color: #1a1a1a;
        }
    </style>
    @stack('styles')
</head>
<body>
    <main>
        @yield('content')
    </main>
    @include('partials.babu88-fonts')
    @stack('scripts')
</body>
</html>
