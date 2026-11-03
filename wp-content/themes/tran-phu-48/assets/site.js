(() => {
'use strict';
const toggle=document.querySelector('.menu-toggle');
const nav=document.querySelector('#main-nav');
const closeMenu=()=>{toggle?.setAttribute('aria-expanded','false');toggle?.setAttribute('aria-label','Mở menu');nav?.classList.remove('is-open');};
toggle?.addEventListener('click',()=>{const open=toggle.getAttribute('aria-expanded')!=='true';toggle.setAttribute('aria-expanded',String(open));toggle.setAttribute('aria-label',open?'Đóng menu':'Mở menu');nav?.classList.toggle('is-open',open);});
nav?.querySelectorAll('a').forEach(a=>a.addEventListener('click',closeMenu));
document.addEventListener('click',e=>{if(!e.target.closest('.site-header'))closeMenu();});
document.addEventListener('keydown',e=>{if(e.key==='Escape'&&toggle?.getAttribute('aria-expanded')==='true'){closeMenu();toggle.focus();}});
matchMedia(document.querySelector('link[href*="home-classic.css"]') ? '(min-width: 701px)' : '(min-width: 901px)').addEventListener('change',closeMenu);
const journalToggle=document.querySelector('[data-journal-toggle]');
journalToggle?.addEventListener('click',()=>{
 const entries=document.querySelector('#journal-entries');if(!entries)return;
 const expanded=journalToggle.getAttribute('aria-expanded')!=='true';
 journalToggle.setAttribute('aria-expanded',String(expanded));entries.hidden=!expanded;
 if(expanded)entries.scrollIntoView({block:'nearest',behavior:matchMedia('(prefers-reduced-motion: reduce)').matches?'instant':'smooth'});
});
// A chosen homepage menu may be longer than the original five links.
if(document.querySelector('link[href*="home-classic.css"]')){
 const header=document.querySelector('.site-header');
 const fitHomeMenu=()=>{
  if(!header||!nav||!toggle)return;
  const before=header.classList.contains('is-menu-collapsed');header.classList.remove('is-menu-collapsed');
  if(innerWidth>700){const style=getComputedStyle(header);const available=header.clientWidth-parseFloat(style.paddingLeft)-parseFloat(style.paddingRight);const brand=header.querySelector('.brand');const required=(brand?.getBoundingClientRect().width||0)+nav.scrollWidth+parseFloat(style.columnGap||0);header.classList.toggle('is-menu-collapsed',required>available+1);}
  if(before!==header.classList.contains('is-menu-collapsed'))closeMenu();
 };
 window.addEventListener('resize',fitHomeMenu);if(document.fonts)document.fonts.ready.then(fitHomeMenu);fitHomeMenu();
}
const dialog=document.querySelector('.lightbox');
const photos=[...document.querySelectorAll('[data-gallery-index]')];
if(dialog&&photos.length){
 let current=0;
 const show=i=>{current=(i+photos.length)%photos.length;const item=photos[current];const img=dialog.querySelector('img');img.src=item.href;img.alt=item.dataset.caption;dialog.querySelector('figcaption').textContent=`${current+1} / ${photos.length} — ${item.dataset.caption}`;};
 document.querySelector('[data-open-gallery]')?.addEventListener('click',()=>{show(0);dialog.showModal();document.body.classList.add('modal-open');});
 photos.forEach((item,i)=>item.addEventListener('click',e=>{e.preventDefault();show(i);dialog.showModal();document.body.classList.add('modal-open');}));
 dialog.querySelector('.lightbox-close')?.addEventListener('click',()=>dialog.close());
 dialog.querySelector('.lightbox-prev')?.addEventListener('click',()=>show(current-1));
 dialog.querySelector('.lightbox-next')?.addEventListener('click',()=>show(current+1));
 dialog.addEventListener('close',()=>document.body.classList.remove('modal-open'));
 dialog.addEventListener('click',e=>{if(e.target===dialog){const r=dialog.getBoundingClientRect();if(e.clientX<r.left||e.clientX>r.right||e.clientY<r.top||e.clientY>r.bottom)dialog.close();}});
 dialog.addEventListener('keydown',e=>{if(e.key==='ArrowLeft'){e.preventDefault();show(current-1);}if(e.key==='ArrowRight'){e.preventDefault();show(current+1);}});
}
const video=document.querySelector('.hero-video');const videoToggle=document.querySelector('.video-toggle');
if(video&&videoToggle){
 const motion=matchMedia('(prefers-reduced-motion: reduce)');
 if(motion.matches)video.pause();
 const label=()=>{videoToggle.textContent=video.paused?'Phát video':'Tạm dừng video';};
 video.addEventListener('play',label);video.addEventListener('pause',label);label();
 videoToggle.addEventListener('click',()=>{if(video.paused){video.play().catch(()=>label());}else video.pause();});
 motion.addEventListener('change',e=>{if(e.matches)video.pause();});
}
})();
