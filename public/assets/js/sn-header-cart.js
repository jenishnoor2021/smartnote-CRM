(function () {
  'use strict';

  /* --------------------------------------------------------
   * 1. CART DROPDOWN VIEWPORT RESIZING
   * -------------------------------------------------------- */
  var carts = document.querySelectorAll('.sn-navigation-cart .header-cart');

  function resizeCarts() {
    var viewport = window.visualViewport;
    var bottom = viewport ? viewport.offsetTop + viewport.height : window.innerHeight;
    carts.forEach(function (cart) {
      var panel = cart.querySelector('.widget_shopping_cart');
      if (panel) {
        panel.style.setProperty('--sn-cart-space', Math.max(0, bottom - cart.getBoundingClientRect().bottom - 12) + 'px');
      }
    });
  }

  carts.forEach(function (cart) {
    var list = cart.querySelector('.cart_list');
    if (list) {
      list.setAttribute('data-lenis-prevent', '');
      list.setAttribute('tabindex', '0');
      list.setAttribute('aria-label', 'Products in your cart');
    }
    cart.addEventListener('pointerenter', resizeCarts);
    cart.addEventListener('focusin', resizeCarts);
  });

  window.addEventListener('resize', resizeCarts);
  window.addEventListener('scroll', resizeCarts, { passive: true });
  if (window.visualViewport) {
    window.visualViewport.addEventListener('resize', resizeCarts);
    window.visualViewport.addEventListener('scroll', resizeCarts);
  }
  resizeCarts();

  /* --------------------------------------------------------
   * 2. CATEGORY DROPDOWN TOGGLE & OUTSIDE-CLICK CLOSING
   * -------------------------------------------------------- */
  function initCategoryDropdown() {
    var $toggler = $('.category-toggler');
    var $nav = $('.vs-box-nav');
    var $wrapper = $('.header-category');

    if (!$toggler.length || !$nav.length) return;

    // Unbind any previous click handlers to prevent double toggling
    $toggler.off('click.snCat').on('click.snCat', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var willOpen = !$nav.hasClass('active');
      $nav.toggleClass('active', willOpen);
      $wrapper.toggleClass('is-open', willOpen);
    });

    // Close on outside click
    $(document).off('click.snCat').on('click.snCat', function (e) {
      if (!$(e.target).closest('.header-category').length) {
        $nav.removeClass('active');
        $wrapper.removeClass('is-open');
      }
    });

    // Close on Escape key
    $(document).off('keydown.snCat').on('keydown.snCat', function (e) {
      if (e.key === 'Escape' || e.keyCode === 27) {
        $nav.removeClass('active');
        $wrapper.removeClass('is-open');
      }
    });
  }

  /* --------------------------------------------------------
   * 3. SEARCH BAR CATEGORY DROPDOWN
   * -------------------------------------------------------- */
  function initSearchCategoryDropdown() {
    var $dropdown = $('.search-cat-dropdown');
    var $toggler = $('.search-cat-toggler');
    var $menu = $('.search-cat-menu');
    var $input = $('#snSearchCategoryInput');
    var $label = $('.selected-cat-label');

    if (!$dropdown.length || !$toggler.length) return;

    // Toggle on click
    $toggler.off('click.snSearchCat').on('click.snSearchCat', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var willOpen = !$menu.hasClass('show');
      $menu.toggleClass('show', willOpen);
      $dropdown.toggleClass('is-open', willOpen);
      $toggler.attr('aria-expanded', willOpen ? 'true' : 'false');
    });

    // Toggle on Enter/Space
    $toggler.off('keydown.snSearchCatToggle').on('keydown.snSearchCatToggle', function (e) {
      if (e.key === 'Enter' || e.key === ' ' || e.keyCode === 13 || e.keyCode === 32) {
        e.preventDefault();
        $toggler.trigger('click');
      }
    });

    // Close on outside click
    $(document).off('click.snSearchCat').on('click.snSearchCat', function (e) {
      if (!$(e.target).closest('.search-cat-dropdown').length) {
        $menu.removeClass('show');
        $dropdown.removeClass('is-open');
        $toggler.attr('aria-expanded', 'false');
      }
    });

    // Close on Escape key
    $(document).off('keydown.snSearchCat').on('keydown.snSearchCat', function (e) {
      if (e.key === 'Escape' || e.keyCode === 27) {
        $menu.removeClass('show');
        $dropdown.removeClass('is-open');
        $toggler.attr('aria-expanded', 'false');
      }
    });

    // Category option click
    $menu.off('click.snSearchCat', '.search-cat-item').on('click.snSearchCat', '.search-cat-item', function (e) {
      var catId = $(this).data('cat-id') || '';
      var catName = $.trim($(this).contents().filter(function () {
        return this.nodeType === 3;
      }).text()) || $.trim($(this).text());

      $input.val(catId);
      $label.text(catId ? catName : 'Categories');
      $menu.find('.search-cat-item').removeClass('active');
      $(this).addClass('active');
      $menu.removeClass('show');
      $dropdown.removeClass('is-open');
      $toggler.attr('aria-expanded', 'false');

      // If search input has no text, navigate directly to that category page
      var searchVal = $.trim($('input[name="search"]').val());
      if (!searchVal) {
        var targetUrl = $(this).attr('href');
        if (targetUrl && targetUrl !== '#' && !targetUrl.startsWith('javascript:')) {
          window.location.href = targetUrl;
          return;
        }
      }
      e.preventDefault();
    });
  }

  function initHeaderControls() {
    initCategoryDropdown();
    initSearchCategoryDropdown();
  }

  if (window.jQuery) {
    $(document).ready(initHeaderControls);
  } else {
    document.addEventListener('DOMContentLoaded', initHeaderControls);
  }

}());
