<div id="app-toast-stack" class="app-toast-stack" aria-live="polite" aria-relevant="additions text"></div>
<style>
    .app-toast-stack {
        position: fixed;
        top: max(12px, env(safe-area-inset-top, 0px));
        right: max(12px, env(safe-area-inset-right, 0px));
        left: auto;
        bottom: auto;
        transform: none;
        z-index: 10050;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
        pointer-events: none;
        width: min(calc(100vw - 24px), 380px);
        max-width: calc(100vw - 24px);
        box-sizing: border-box;
        padding: 0;
    }
    .app-toast {
        pointer-events: auto;
        margin: 0;
        padding: 12px 16px;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.14);
        font-size: clamp(14px, 3.5vw, 15px);
        line-height: 1.45;
        font-weight: 600;
        text-align: left;
        animation: app-toast-in 0.3s ease-out;
        max-width: 100%;
        word-break: break-word;
        background: linear-gradient(180deg, #ffe082 0%, #ffce01 45%, #f0b800 100%);
        color: #111;
        border: 1px solid rgba(0, 0, 0, 0.14);
    }
    .app-toast--success,
    .app-toast--error,
    .app-toast--info {
        background: linear-gradient(180deg, #ffe082 0%, #ffce01 45%, #f0b800 100%);
        color: #111;
    }
    .app-toast--out {
        animation: app-toast-out 0.22s ease-in forwards;
    }
    @keyframes app-toast-in {
        from {
            opacity: 0;
            transform: translateX(16px) scale(0.97);
        }
        to {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }
    @keyframes app-toast-out {
        to {
            opacity: 0;
            transform: translateX(12px) scale(0.97);
        }
    }
</style>
<script>
(function () {
    var stack = null;
    function getStack() {
        if (!stack) stack = document.getElementById('app-toast-stack');
        return stack;
    }
    /* showToast(message, opts) — opts.type: success|error|info, opts.duration: ms */
    window.showToast = function (message, opts) {
        if (!message) return;
        opts = opts || {};
        var type = opts.type || 'info';
        var duration = typeof opts.duration === 'number' ? opts.duration : (type === 'error' ? 5200 : 3800);
        var root = getStack();
        if (!root) {
            if (type === 'error') window.alert(message);
            return;
        }
        var el = document.createElement('div');
        el.className = 'app-toast app-toast--' + (type === 'success' || type === 'error' || type === 'info' ? type : 'info');
        el.setAttribute('role', type === 'error' ? 'alert' : 'status');
        el.setAttribute('title', 'বন্ধ করতে ট্যাপ করুন');
        el.style.cursor = 'pointer';
        el.textContent = message;
        root.appendChild(el);
        var t = window.setTimeout(function () {
            el.classList.add('app-toast--out');
            window.setTimeout(function () {
                el.remove();
            }, 220);
        }, duration);
        el.addEventListener('click', function () {
            window.clearTimeout(t);
            el.classList.add('app-toast--out');
            window.setTimeout(function () { el.remove(); }, 220);
        });
    };
})();
</script>
