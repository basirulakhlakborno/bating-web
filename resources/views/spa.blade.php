@php
    $manifestPath = public_path('dist/.vite/manifest.json');
    $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];
    $entry = $manifest['index.html'] ?? $manifest['src/main.tsx'] ?? [];
    $jsFile = $entry['file'] ?? null;
    $cssFiles = $entry['css'] ?? [];
    $siteName = config('app.name', 'Babu88');
    $htmlTitle = (string) ($siteData['layoutSiteHtmlTitle'] ?? '');
    $metaDesc = (string) ($siteData['layoutSiteMetaDescription'] ?? '');
    $metaKeywords = (string) ($siteData['layoutSiteMetaKeywords'] ?? '');
    $headerLogo = (string) ($siteData['layoutSiteHeaderLogoPath'] ?? '');
    $loaderAria = (string) ($siteData['layoutSiteLoaderAriaLabel'] ?? '');
    $ogImagePath = (string) ($siteData['layoutSiteOgImage'] ?? '');
    $ogImageFull = $ogImagePath !== ''
        ? (str_starts_with($ogImagePath, 'http') ? $ogImagePath : url($ogImagePath))
        : '';
@endphp
<!doctype html>
<html lang="bn">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    @if ($htmlTitle !== '')
        <meta name="title" content="{{ $htmlTitle }}" />
    @endif
    @if ($metaDesc !== '')
        <meta name="description" content="{{ $metaDesc }}" />
    @endif
    @if ($metaKeywords !== '')
        <meta name="keywords" content="{{ $metaKeywords }}" />
    @endif
    @if ($htmlTitle !== '')
        <meta property="og:title" content="{{ $htmlTitle }}" />
    @endif
    @if ($metaDesc !== '')
        <meta property="og:description" content="{{ $metaDesc }}" />
    @endif
    <meta property="og:url" content="{{ config('app.url', '/') }}" />
    <meta property="og:site_name" content="{{ $siteName }}" />
    @if ($ogImageFull !== '')
        <meta property="og:image" content="{{ $ogImageFull }}" />
    @endif
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:image:alt" content="{{ $siteName }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="bookmark" href="/favicon.ico" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <title>{{ $htmlTitle }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons" />
    <link rel="preload" href="/dist/css/chunk-vendors.544b9641.css" as="style" />
    <link rel="preload" href="/dist/css/app.2e795c71.css" as="style" />
    <link rel="stylesheet" href="/dist/css/chunk-vendors.544b9641.css" />
    <link rel="stylesheet" href="/dist/css/app.2e795c71.css" />
    <link rel="stylesheet" href="/dist/css/chunk-745f18e8.f9f3f906.css" />
    <link rel="stylesheet" href="/dist/css/babu88-fonts.css" />
    <link rel="stylesheet" href="/dist/css/auth-page-styles.css" />
    <link rel="stylesheet" href="/dist/css/toast-stack.css" />
    @foreach ($cssFiles as $css)
        <link rel="stylesheet" crossorigin href="/dist/{{ $css }}" />
    @endforeach
    @if ($jsFile)
        <script type="module" crossorigin src="/dist/{{ $jsFile }}"></script>
    @endif
</head>
<body>
    <div
        id="app-page-loader"
        class="app-page-loader"
        role="status"
        aria-live="polite"
        aria-busy="true"
        @if ($loaderAria !== '') aria-label="{{ $loaderAria }}" @endif
        style="position:fixed;inset:0;z-index:2147483000;display:flex;align-items:center;justify-content:center;background:rgba(46,46,46,0.94)"
    >
        <div class="app-page-loader__inner">
            @if ($headerLogo !== '')
                <img
                    class="app-page-loader__logo"
                    src="{{ str_starts_with($headerLogo, 'http') ? $headerLogo : url($headerLogo) }}"
                    alt=""
                    width="215"
                    height="45"
                    decoding="async"
                />
            @endif
        </div>
    </div>
    <script src="/dist/js/page-loader.js"></script>
    <script>
        window.__SITE_DATA__ = {!! json_encode($siteData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!};
    </script>
    <main>
        <div id="root"></div>
    </main>
    <div id="app-toast-stack" class="app-toast-stack" aria-live="polite" aria-relevant="additions text"></div>
    <script src="/dist/js/toast-stack.js"></script>
</body>
</html>
