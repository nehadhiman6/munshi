/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/js/customs/sidebar_toggle.js ***!
  \************************************************/
window, document, window.jQuery;

(function (window, document, $, undefined) {
  $(function () {
    var scrollbar = jQuery(".scrollbar");

    if (scrollbar.length > 0) {
      $('.scroll_dark').mCustomScrollbar({
        theme: "minimal-dark",
        setHeight: false,
        scrollInertia: 0,
        mouseWheel: {
          normalizeDelta: true,
          scrollAmount: '200px',
          contentTouchScroll: true,
          deltaFactor: '200px'
        },
        advanced: {
          autoScrollOnFocus: 'a[tabindex]'
        }
      });
      $('.scroll_light').mCustomScrollbar({
        theme: "minimal",
        setHeight: false,
        scrollInertia: 0,
        mouseWheel: {
          normalizeDelta: true,
          scrollAmount: '200px',
          contentTouchScroll: true,
          eltaFactor: '200px'
        },
        advanced: {
          autoScrollOnFocus: 'a[tabindex]'
        }
      });
    }
  });
})(window, document, window.jQuery);

(function (window, document, $, undefined) {
  $(function () {
    var sidebarNav = jQuery(".sidebar-nav");

    if (sidebarNav.length > 0) {
      $('#sidebarNav').metisMenu();
    }
  });
})(window, document, window.jQuery);

(function (window, document, $, undefined) {
  $(function () {
    $('.mobile-toggle').on('click', function () {
      $('body').toggleClass('sidebar-toggled');
      $('.navbar-header').toggleClass('expand');
    });
    $(document).on('click', '.mega-menu.dropdown-menu', function (e) {
      e.stopPropagation();
    });
    $('.sidebar-toggle').on('click', function () {
      $('body').toggleClass('sidebar-mini');
      $('.app-navbar').toggleClass('expand');
    });
    $('.app-navbar').hover(function () {
      if ($('body').hasClass('sidebar-mini')) {
        $('.navbar-header').toggleClass('expand');
      }
    });
    $('.search').on('click', function () {
      $('.search-wrapper').fadeIn(200);
    }); //Search Box Close

    $('.close-btn').on('click', function () {
      $('.search-wrapper').fadeOut(200);
    });
    $('.iw-default-theme').click(function () {
      $('body').removeClass('theme-dark');
      $('body').removeClass('theme-light');
    });
    $('.iw-dark-theme').click(function () {
      $('body').addClass('theme-dark');
      $('body').removeClass('theme-light');
    });
    $('.iw-light-theme').click(function () {
      $('body').addClass('theme-light');
      $('body').removeClass('theme-dark');
    });
  });
})(window, document, window.jQuery);
/******/ })()
;