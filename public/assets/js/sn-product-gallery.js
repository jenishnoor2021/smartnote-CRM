(() => {
  'use strict';
  const gallery = document.querySelector('.sn-product-gallery');
  const modalElement = document.getElementById('snGalleryModal');
  if (!gallery || !modalElement || !window.bootstrap?.Modal) return;
  const thumbnails = Array.from(gallery.querySelectorAll('.sn-gallery-thumb'));
  if (!thumbnails.length) return;
  const mainImage = gallery.querySelector('.sn-gallery-open img');
  const popupImage = modalElement.querySelector('.sn-gallery-lightbox img');
  const counter = modalElement.querySelector('.sn-gallery-counter');
  const rail = gallery.querySelector('.sn-gallery-thumbnails');
  const modal = new bootstrap.Modal(modalElement);
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  let selected = 0;
  let opened = false;
  let touchStart = null;
  let animation;

  function select(index) {
    selected = (index + thumbnails.length) % thumbnails.length;
    const source = thumbnails[selected].querySelector('img');
    [mainImage, popupImage].forEach(image => {
      image.src = source.getAttribute('src');
      image.alt = source.alt;
    });
    animation?.cancel();
    if (!reducedMotion.matches && mainImage.animate) {
      animation = mainImage.animate([{ opacity: .4 }, { opacity: 1 }], { duration: 200 });
    }
    thumbnails.forEach((button, i) => button.setAttribute('aria-pressed', String(i === selected)));
    counter.textContent = `${selected + 1} / ${thumbnails.length}`;
    const active = thumbnails[selected];
    const vertical = window.matchMedia('(min-width: 992px)').matches;
    rail.scrollTo({
      left: vertical ? 0 : active.offsetLeft - rail.offsetLeft - (rail.clientWidth - active.clientWidth) / 2,
      top: vertical ? active.offsetTop - rail.offsetTop - (rail.clientHeight - active.clientHeight) / 2 : 0,
      behavior: reducedMotion.matches ? 'auto' : 'smooth'
    });
  }
  thumbnails.forEach((button, index) => button.addEventListener('click', () => select(index)));
  gallery.querySelectorAll('.sn-gallery-scroll').forEach(button => {
    button.addEventListener('click', () => {
      const vertical = window.matchMedia('(min-width: 992px)').matches;
      const amount = Number(button.dataset.direction) * (vertical ? rail.clientHeight : rail.clientWidth) * .8;
      rail.scrollBy({ left: vertical ? 0 : amount, top: vertical ? amount : 0, behavior: reducedMotion.matches ? 'auto' : 'smooth' });
    });
  });
  const opener = gallery.querySelector('.sn-gallery-open');
  opener.addEventListener('click', () => modal.show());
  modalElement.addEventListener('shown.bs.modal', () => { opened = true; });
  modalElement.addEventListener('hidden.bs.modal', () => { opened = false; touchStart = null; opener.focus(); });
  modalElement.querySelector('.sn-gallery-prev').addEventListener('click', () => select(selected - 1));
  modalElement.querySelector('.sn-gallery-next').addEventListener('click', () => select(selected + 1));
  modalElement.addEventListener('keydown', event => {
    if (!opened || !['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
    event.preventDefault();
    select(selected + (event.key === 'ArrowRight' ? 1 : -1));
  });
  const lightbox = modalElement.querySelector('.sn-gallery-lightbox');
  lightbox.addEventListener('touchstart', event => {
    touchStart = event.touches.length === 1 ? { x: event.touches[0].clientX, y: event.touches[0].clientY } : null;
  }, { passive: true });
  lightbox.addEventListener('touchend', event => {
    if (!touchStart || !opened) return;
    const dx = event.changedTouches[0].clientX - touchStart.x;
    const dy = event.changedTouches[0].clientY - touchStart.y;
    touchStart = null;
    if (Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy)) select(selected + (dx < 0 ? 1 : -1));
  }, { passive: true });
  lightbox.addEventListener('touchcancel', () => { touchStart = null; }, { passive: true });
  // Server-rendered thumbnails are the single source of gallery data.
  select(0);
})();
