(() => {
  'use strict';
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('#main-nav');
  const closeMenu = () => { toggle?.setAttribute('aria-expanded', 'false'); toggle?.setAttribute('aria-label', 'Mở menu'); nav?.classList.remove('is-open'); };
  toggle?.addEventListener('click', () => {
    const opened = toggle.getAttribute('aria-expanded') !== 'true';
    toggle.setAttribute('aria-expanded', String(opened));
    toggle.setAttribute('aria-label', opened ? 'Đóng menu' : 'Mở menu');
    nav.classList.toggle('is-open', opened);
  });
  nav?.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
  document.addEventListener('click', event => { if (!event.target.closest('.site-header')) closeMenu(); });
  document.addEventListener('keydown', event => { if (event.key === 'Escape' && toggle?.getAttribute('aria-expanded') === 'true') { closeMenu(); toggle.focus(); } });
  window.matchMedia('(min-width: 701px)').addEventListener('change', closeMenu);
  const journalToggle = document.querySelector('[data-journal-toggle]');
  journalToggle?.addEventListener('click', () => {
    const entries = document.querySelector('#journal-entries');
    const expanded = journalToggle.getAttribute('aria-expanded') !== 'true';
    journalToggle.setAttribute('aria-expanded', String(expanded));
    entries.hidden = !expanded;
    if (expanded) entries.scrollIntoView({block: 'nearest', behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth'});
  });
  const dialog = document.querySelector('.lightbox');
  const photos = [...document.querySelectorAll('[data-gallery-index]')];
  if (dialog && photos.length) {
    let current = 0;
    const show = index => {
      current = (index + photos.length) % photos.length;
      const item = photos[current];
      const img = dialog.querySelector('img');
      img.src = item.href;
      img.alt = item.dataset.caption;
      dialog.querySelector('figcaption').textContent = `${current + 1} / ${photos.length} — ${item.dataset.caption}`;
    };
    const open = index => { show(index); dialog.showModal(); document.body.classList.add('modal-open'); };
    photos.forEach((item, index) => item.addEventListener('click', event => { event.preventDefault(); open(index); }));
    document.querySelector('[data-open-gallery]')?.addEventListener('click', () => open(0));
    dialog.querySelector('.lightbox-close').addEventListener('click', () => dialog.close());
    dialog.querySelector('.lightbox-prev').addEventListener('click', () => show(current - 1));
    dialog.querySelector('.lightbox-next').addEventListener('click', () => show(current + 1));
    dialog.addEventListener('close', () => document.body.classList.remove('modal-open'));
    dialog.addEventListener('click', event => { if (event.target === dialog) { const box = dialog.getBoundingClientRect(); if (event.clientX < box.left || event.clientX > box.right || event.clientY < box.top || event.clientY > box.bottom) dialog.close(); } });
    dialog.addEventListener('keydown', event => { if (event.key === 'ArrowLeft') { event.preventDefault(); show(current - 1); } if (event.key === 'ArrowRight') { event.preventDefault(); show(current + 1); } });
  }
})();
