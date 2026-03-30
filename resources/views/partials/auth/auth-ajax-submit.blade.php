{{-- Shared fetch() submit for auth forms; expects meta[name="csrf-token"]; optional beforeFetch, afterError, successMessage --}}
<script>
(function () {
    function csrfToken() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? (m.getAttribute('content') || '') : '';
    }
    function flattenErrors(data) {
        if (!data) return '';
        if (typeof data === 'string') return data;
        if (data.message && typeof data.errors !== 'object') return data.message;
        if (data.errors && typeof data.errors === 'object') {
            var msgs = [];
            Object.keys(data.errors).forEach(function (k) {
                (data.errors[k] || []).forEach(function (line) { msgs.push(line); });
            });
            return msgs.join(' ') || data.message || '';
        }
        return data.message || '';
    }
    window.initAuthAjaxForm = function (formSelector, options) {
        options = options || {};
        function bind() {
            if (!window.fetch) return;
            var form = typeof formSelector === 'string' ? document.querySelector(formSelector) : formSelector;
            if (!form || form.getAttribute('data-ajax-bound') === '1') return;
            form.setAttribute('data-ajax-bound', '1');
            var errEl = options.errorId ? document.getElementById(options.errorId) : null;
            var submits = form.querySelectorAll('button[type="submit"], input[type="submit"]');
            function setBusy(on) {
                submits.forEach(function (btn) {
                    btn.disabled = on;
                    btn.setAttribute('aria-busy', on ? 'true' : 'false');
                });
            }
            function showErr(text) {
                if (!errEl) return;
                errEl.textContent = text || '';
                if (text) {
                    errEl.hidden = false;
                    errEl.style.display = '';
                } else {
                    errEl.hidden = true;
                    errEl.style.display = 'none';
                }
            }
            function toastErr(text) {
                if (typeof window.showToast === 'function') {
                    window.showToast(text, { type: 'error' });
                }
            }
            function toastOk(text) {
                if (typeof window.showToast === 'function') {
                    window.showToast(text, { type: 'success' });
                }
            }
            form.addEventListener('submit', function (e) {
                if (!window.fetch) return;
                e.preventDefault();
                e.stopPropagation();
                showErr('');
                if (typeof options.beforeFetch === 'function') {
                    if (options.beforeFetch(form) === false) return;
                }
                setBusy(true);
                var fd = new FormData(form);
                fetch(form.getAttribute('action') || '', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken()
                    },
                    body: fd,
                    credentials: 'same-origin'
                }).then(function (r) {
                    return r.text().then(function (text) {
                        var data = {};
                        if (text) {
                            try { data = JSON.parse(text); } catch (err) { data = { message: text.slice(0, 200) }; }
                        }
                        return { ok: r.ok, status: r.status, data: data };
                    });
                }).then(function (res) {
                    setBusy(false);
                    if (res.status === 419) {
                        window.location.reload();
                        return;
                    }
                    if (res.ok && res.data && res.data.redirect) {
                        var okText = options.successMessage || res.data.message || '';
                        if (okText) toastOk(okText);
                        window.setTimeout(function () {
                            window.location.assign(res.data.redirect);
                        }, okText ? 550 : 0);
                        return;
                    }
                    var msg = flattenErrors(res.data) || 'অনুরোধ সম্পূর্ণ হয়নি।';
                    showErr(msg);
                    toastErr(msg);
                    if (typeof options.afterError === 'function') {
                        options.afterError(res, msg);
                    }
                }).catch(function () {
                    setBusy(false);
                    var netMsg = 'নেটওয়ার্ক ত্রুটি। অনুগ্রহ করে আবার চেষ্টা করুন।';
                    showErr(netMsg);
                    toastErr(netMsg);
                    if (typeof options.afterError === 'function') {
                        options.afterError({ ok: false, status: 0, data: {} }, 'network');
                    }
                });
            }, true);
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bind);
        } else {
            bind();
        }
    };
})();
</script>
