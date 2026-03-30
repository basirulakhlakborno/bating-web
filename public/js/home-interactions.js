(function () {
  'use strict';

  // ── Download Bar Dismiss ──
  var dlBar = document.querySelector('.download-bar');
  if (dlBar) {
    var closeBtn = dlBar.querySelector('.mdi-close');
    if (closeBtn) {
      closeBtn.addEventListener('click', function () {
        dlBar.style.display = 'none';
      });
    }
  }

  // ── Mobile Navigation Drawer Toggle ──
  var drawer = document.querySelector('.mobile-navigation-drawer');
  var overlay = document.getElementById('nav-drawer-overlay');

  function openDrawer() {
    if (!drawer) return;
    drawer.classList.remove('v-navigation-drawer--close');
    drawer.classList.add('v-navigation-drawer--open');
    drawer.style.transform = 'translateX(0%)';
    if (overlay) {
      overlay.style.display = '';
      var scrim = overlay.querySelector('.v-overlay__scrim');
      if (scrim) scrim.style.opacity = '0.46';
    }
  }

  function closeDrawer() {
    if (!drawer) return;
    drawer.classList.add('v-navigation-drawer--close');
    drawer.classList.remove('v-navigation-drawer--open');
    drawer.style.transform = 'translateX(-100%)';
    if (overlay) {
      var scrim = overlay.querySelector('.v-overlay__scrim');
      if (scrim) scrim.style.opacity = '0';
      setTimeout(function () { overlay.style.display = 'none'; }, 200);
    }
  }

  var hamburger = document.querySelector('.v-app-bar__nav-icon');
  if (hamburger) hamburger.addEventListener('click', openDrawer);

  var drawerMenuIcon = drawer ? drawer.querySelector('.mobile-drawer-menu-icon') : null;
  if (drawerMenuIcon) drawerMenuIcon.addEventListener('click', closeDrawer);

  if (overlay) overlay.addEventListener('click', closeDrawer);

  // ── Currency / Language dialog ──
  var currencyDialogRoot = document.getElementById('currency-language-dialog-root');
  var currencyDialogScrim = currencyDialogRoot ? currencyDialogRoot.querySelector('.currency-language-dialog-scrim') : null;
  var currencyDialogSheet = currencyDialogRoot ? currencyDialogRoot.querySelector('.currency-language-dialog-sheet') : null;

  var currencyDialogOverflowTimer;

  function openCurrencyDialog() {
    if (!currencyDialogRoot) return;
    clearTimeout(currencyDialogOverflowTimer);
    currencyDialogRoot.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    currencyDialogRoot.classList.add('is-open');
    var closeBtn = currencyDialogRoot.querySelector('.currency-language-dialog-close');
    if (closeBtn) closeBtn.focus();
  }

  function closeCurrencyDialog() {
    if (!currencyDialogRoot) return;
    currencyDialogRoot.classList.remove('is-open');
    currencyDialogRoot.setAttribute('aria-hidden', 'true');
    clearTimeout(currencyDialogOverflowTimer);
    currencyDialogOverflowTimer = setTimeout(function () {
      if (!currencyDialogRoot.classList.contains('is-open')) {
        document.body.style.overflow = '';
      }
    }, 320);
  }

  document.querySelectorAll('.currency-language-dialog-trigger').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      openCurrencyDialog();
    });
  });

  if (currencyDialogScrim) {
    currencyDialogScrim.addEventListener('click', closeCurrencyDialog);
  }

  if (currencyDialogRoot) {
    var closeCurrencyBtn = currencyDialogRoot.querySelector('.currency-language-dialog-close');
    if (closeCurrencyBtn) {
      closeCurrencyBtn.addEventListener('click', function (e) {
        e.preventDefault();
        closeCurrencyDialog();
      });
    }
    currencyDialogRoot.querySelectorAll('.v-btn-toggle .currency-lang-btn').forEach(function (langBtn) {
      langBtn.addEventListener('click', function () {
        var group = langBtn.closest('.v-btn-toggle');
        if (!group) return;
        group.querySelectorAll('.currency-lang-btn').forEach(function (b) {
          b.classList.remove('v-item--active', 'v-btn--active');
        });
        langBtn.classList.add('v-item--active', 'v-btn--active');
      });
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && currencyDialogRoot && currencyDialogRoot.classList.contains('is-open')) {
      closeCurrencyDialog();
    }
  });

  if (currencyDialogSheet) {
    currencyDialogSheet.addEventListener('click', function (e) {
      e.stopPropagation();
    });
  }

  // ── Generic Carousel Helper ──
  function initCarousel(container, options) {
    if (!container) return null;
    var slides = container.querySelectorAll(':scope > .v-window-item');
    if (!slides.length) return null;

    var current = 0;
    var timer;
    var interval = (options && options.interval) || 5000;
    var stableAspect = options && options.stableAspect;

    if (stableAspect) {
      container.style.position = 'relative';
      container.style.height = '0';
      container.style.paddingBottom = stableAspect;
      container.style.overflow = 'hidden';
      slides.forEach(function (sl) {
        sl.style.position = 'absolute';
        sl.style.top = '0';
        sl.style.left = '0';
        sl.style.width = '100%';
        sl.style.height = '100%';
        sl.style.margin = '0';
        sl.style.boxSizing = 'border-box';
      });
    }

    for (var i = 0; i < slides.length; i++) {
      if (slides[i].style.display !== 'none') {
        current = i;
        break;
      }
    }

    function show(idx) {
      if (idx < 0) idx = slides.length - 1;
      if (idx >= slides.length) idx = 0;
      for (var j = 0; j < slides.length; j++) {
        var sl = slides[j];
        sl.classList.remove(
          'v-window-x-transition-enter-active',
          'v-window-x-transition-enter-to',
          'v-window-x-transition-leave-active',
          'v-window-x-transition-leave-to'
        );
        if (stableAspect) {
          if (j === idx) {
            sl.style.display = '';
            sl.style.opacity = '1';
            sl.style.visibility = 'visible';
            sl.style.zIndex = '2';
            sl.style.pointerEvents = '';
          } else {
            sl.style.display = '';
            sl.style.opacity = '0';
            sl.style.visibility = 'hidden';
            sl.style.zIndex = '1';
            sl.style.pointerEvents = 'none';
          }
        } else {
          sl.style.display = j === idx ? '' : 'none';
        }
      }
      current = idx;

      if (options && options.dots) {
        var dotBtns = options.dots.querySelectorAll('button');
        dotBtns.forEach(function (btn, di) {
          if (di === idx) {
            btn.classList.add('v-item--active', 'v-btn--active');
          } else {
            btn.classList.remove('v-item--active', 'v-btn--active');
          }
        });
      }
    }

    function next() { show(current + 1); }
    function prev() { show(current - 1); }

    function resetTimer() {
      clearInterval(timer);
      timer = setInterval(next, interval);
    }

    show(current);
    resetTimer();
    return { show: show, next: next, prev: prev, resetTimer: resetTimer, getCurrent: function () { return current; } };
  }

  // ── Mobile Banner Carousel ──
  var mobileContainer = document.querySelector('.home-banner-carousel-mobile .v-window__container');
  var mobileCarousel = initCarousel(mobileContainer, { stableAspect: '44.4444%' });

  var mobilePrev = document.querySelector('.home-banner-carousel-mobile .v-window__prev button');
  var mobileNext = document.querySelector('.home-banner-carousel-mobile .v-window__next button');
  if (mobilePrev && mobileCarousel) {
    mobilePrev.addEventListener('click', function () { mobileCarousel.prev(); mobileCarousel.resetTimer(); });
  }
  if (mobileNext && mobileCarousel) {
    mobileNext.addEventListener('click', function () { mobileCarousel.next(); mobileCarousel.resetTimer(); });
  }

  // ── Desktop Banner Carousel ──
  var desktopBanner = document.querySelector('.banner-height');
  if (desktopBanner) {
    var desktopContainer = desktopBanner.querySelector('.v-window__container');
    var dotsContainer = desktopBanner.querySelector('.v-carousel__controls .v-item-group');
    var desktopCarousel = initCarousel(desktopContainer, { dots: dotsContainer, interval: 5000 });

    var dPrev = desktopBanner.querySelector('.prev-btn');
    var dNext = desktopBanner.querySelector('.next-btn');
    if (dPrev && desktopCarousel) {
      dPrev.addEventListener('click', function () { desktopCarousel.prev(); desktopCarousel.resetTimer(); });
    }
    if (dNext && desktopCarousel) {
      dNext.addEventListener('click', function () { desktopCarousel.next(); desktopCarousel.resetTimer(); });
    }

    if (dotsContainer && desktopCarousel) {
      var dotBtns = dotsContainer.querySelectorAll('button');
      dotBtns.forEach(function (btn, idx) {
        btn.addEventListener('click', function () {
          desktopCarousel.show(idx);
          desktopCarousel.resetTimer();
        });
      });
    }
  }

  // ── Game Menu Tab Selection ──
  var gameMenuButtons = document.querySelectorAll('#game-menu-full .game-menu-button');
  gameMenuButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      gameMenuButtons.forEach(function (b) { b.classList.remove('selected'); });
      btn.classList.add('selected');
    });
  });

  // ── Live Chat Button ──
  var liveChatBtn = document.getElementById('my_custom_link');
  if (liveChatBtn) {
    liveChatBtn.addEventListener('click', function () {
      if (typeof window.Intercom === 'function') {
        window.Intercom('show');
      }
    });
  }

  // ── Ambassador Carousel Dots ──
  document.querySelectorAll('.carousel-controls .control-dot, .d-flex.justify-center .control-dot').forEach(function (dot) {
    dot.addEventListener('click', function () {
      dot.parentElement.querySelectorAll('.control-dot').forEach(function (d) { d.classList.remove('active'); });
      dot.classList.add('active');
    });
  });

  // ── SEO Read More Toggle ──
  var readMore = document.querySelector('.readMore');
  if (readMore) {
    var seoSection = document.querySelector('.second_footer');
    readMore.addEventListener('click', function () {
      if (seoSection) {
        seoSection.style.display = seoSection.style.display === 'none' ? '' : 'none';
      }
    });
  }

  // ── Cricket Highlights Horizontal Scroll ──
  var matchesBox = document.querySelector('.matches-box');
  if (matchesBox) {
    var isDown = false, startX, scrollLeft;
    matchesBox.addEventListener('mousedown', function (e) {
      isDown = true; startX = e.pageX - matchesBox.offsetLeft; scrollLeft = matchesBox.scrollLeft;
    });
    matchesBox.addEventListener('mouseleave', function () { isDown = false; });
    matchesBox.addEventListener('mouseup', function () { isDown = false; });
    matchesBox.addEventListener('mousemove', function (e) {
      if (!isDown) return;
      e.preventDefault();
      matchesBox.scrollLeft = scrollLeft - (e.pageX - matchesBox.offsetLeft - startX) * 2;
    });
  }
})();
