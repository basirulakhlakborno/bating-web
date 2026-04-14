<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; width: 100%; overflow: hidden; background: #0d1117; }
        .frame-wrap { width: 100%; height: 100%; }
        #game-frame {
            display: block;
            width: 100%;
            height: 100%;
            border: 0;
            background: #000;
        }
        .msg { color: #c9d1d9; padding: 24px; font-family: system-ui, sans-serif; }
        .msg a { color: #58a6ff; }
    </style>
</head>
@php
    $bridgeUrl = $gameBridgeUrl ?? '';
    $tokenQuery = request()->query('token');
    $iframeSrcInitial = null;
    if ($bridgeUrl !== '' && is_string($tokenQuery) && $tokenQuery !== '') {
        $iframeSrcInitial = $bridgeUrl.(str_contains($bridgeUrl, '?') ? '&' : '?').'token='.rawurlencode($tokenQuery);
    }
@endphp
<body>
    <div class="frame-wrap">
        <iframe
            id="game-frame"
            title="{{ e($pageTitle) }}"
            allow="fullscreen"
            loading="eager"
            data-bridge-url="{{ e($bridgeUrl) }}"
            @if ($iframeSrcInitial)
                src="{{ e($iframeSrcInitial) }}"
            @endif
        ></iframe>
    </div>
    <script>
        (function () {
            var frame = document.getElementById('game-frame');
            var wrap = frame && frame.parentElement;
            var bridgeUrl = frame && frame.getAttribute('data-bridge-url');
            if (!bridgeUrl) {
                if (wrap) {
                    wrap.innerHTML = '<p class="msg">Game URL is not configured.</p>';
                }
                return;
            }
            function startBridge(token) {
                if (!frame || !token) return;
                var sep = bridgeUrl.indexOf('?') >= 0 ? '&' : '?';
                frame.src = bridgeUrl + sep + 'token=' + encodeURIComponent(token);
            }
            /** Parent SPA (other origin in dev) can pass the JWT; shell iframe cannot read parent localStorage. */
            window.addEventListener('message', function (ev) {
                var data = ev.data;
                if (!data || data.type !== 'babu88-bridge-token') return;
                if (typeof data.token !== 'string' || !data.token) return;
                if (ev.source !== window.parent) return;
                startBridge(data.token.trim());
            });
            @if (! $iframeSrcInitial)
            var token = localStorage.getItem('babu88_auth_token');
            if (!token) {
                try {
                    token = new URLSearchParams(window.location.search).get('token');
                } catch (e) {}
            }
            if (token) {
                startBridge(token);
            } else {
                window.setTimeout(function () {
                    if (!frame || frame.getAttribute('src')) return;
                    if (wrap) {
                        wrap.innerHTML = '<p class="msg">খেলতে <a href="/login">লগ ইন</a> করুন।</p>';
                    }
                }, 800);
            }
            @endif
        })();
    </script>
</body>
</html>
