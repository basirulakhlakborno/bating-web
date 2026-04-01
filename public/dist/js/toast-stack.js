/* From partials/toast-stack.blade.php <script> */
;(function () {
  var stack = null
  function getStack() {
    if (!stack) stack = document.getElementById('app-toast-stack')
    return stack
  }
  window.showToast = function (message, opts) {
    if (!message) return
    opts = opts || {}
    var type = opts.type || 'info'
    var duration = typeof opts.duration === 'number' ? opts.duration : type === 'error' ? 5200 : 3800
    var root = getStack()
    if (!root) {
      if (type === 'error') window.alert(message)
      return
    }
    var el = document.createElement('div')
    el.className =
      'app-toast app-toast--' + (type === 'success' || type === 'error' || type === 'info' ? type : 'info')
    el.setAttribute('role', type === 'error' ? 'alert' : 'status')
    el.setAttribute('title', 'বন্ধ করতে ট্যাপ করুন')
    el.style.cursor = 'pointer'
    el.textContent = message
    root.appendChild(el)
    var t = window.setTimeout(function () {
      el.classList.add('app-toast--out')
      window.setTimeout(function () {
        el.remove()
      }, 220)
    }, duration)
    el.addEventListener('click', function () {
      window.clearTimeout(t)
      el.classList.add('app-toast--out')
      window.setTimeout(function () {
        el.remove()
      }, 220)
    })
  }
})()
