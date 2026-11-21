(function () {
  'use strict';

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
}());
