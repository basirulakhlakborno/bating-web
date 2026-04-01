/* Full-page logo loader: initial boot + manual AJAX busy (login/register, etc.). */
;(function () {
  var el = document.getElementById('app-page-loader')
  var boot = true
  var ajax = 0

  function update() {
    if (!el) return
    var on = boot || ajax > 0
    if (on) {
      el.removeAttribute('hidden')
      el.setAttribute('aria-busy', 'true')
    } else {
      el.setAttribute('hidden', '')
      el.setAttribute('aria-busy', 'false')
    }
  }

  window.__babu88BootLoaderDone = function () {
    boot = false
    update()
  }

  window.babu88PushLoading = function () {
    ajax++
    update()
  }

  window.babu88PopLoading = function () {
    ajax = Math.max(0, ajax - 1)
    update()
  }

  update()
})()
