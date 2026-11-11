(() => {
'use strict';
// Animate each homepage section once as it enters the viewport.
// Content stays visible if JavaScript or IntersectionObserver is unavailable.
const home=document.querySelector('.home-page');
if(home && 'IntersectionObserver' in window){
 const reducedMotion=matchMedia('(prefers-reduced-motion: reduce)');
 const blocks=[...home.querySelectorAll(':scope > section:not(.hero), :scope > .pillars')];
 const seen=new WeakSet();
 const reveal=block=>{
  if(seen.has(block))return;
  seen.add(block);observer.unobserve(block);
  if(!reducedMotion.matches && !block.contains(document.activeElement)){
   block.classList.add('home-block-reveal');
   block.addEventListener('animationend',event=>{if(event.target===block)block.classList.remove('home-block-reveal');});
  }
 };
 const observer=new IntersectionObserver(entries=>{
  entries.forEach(entry=>{if(entry.isIntersecting)reveal(entry.target);});
 },{rootMargin:'0px 0px -32px 0px',threshold:0});
 const syncMotion=()=>{
  observer.disconnect();
  blocks.forEach(block=>{
   block.classList.remove('home-block-reveal');
   if(!reducedMotion.matches && !seen.has(block))observer.observe(block);
  });
 };
 home.addEventListener('focusin',event=>{
  const block=blocks.find(item=>item.contains(event.target));
  if(block){seen.add(block);observer.unobserve(block);block.classList.remove('home-block-reveal');}
 });
 reducedMotion.addEventListener('change',syncMotion);syncMotion();
}
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
// Add a web-only credit to the two archival photos; original media files stay intact.
document.querySelectorAll('.single-story .entry-content img').forEach(img=>{
 const path=new URL(img.getAttribute('src')||'',document.baseURI).pathname;
 if(!/\/IMG_310[35](?:-\d+x\d+|-scaled)?\.jpe?g$/i.test(path)||img.closest('.photo-credit'))return;
 const frame=document.createElement('span');frame.className='photo-credit';
 ['aligncenter','alignleft','alignright'].forEach(name=>{if(img.classList.contains(name)){frame.classList.add(name);img.classList.remove(name);}});
 img.replaceWith(frame);frame.append(img);
 const credit=document.createElement('span');credit.className='photo-credit-label';credit.textContent='48tranphu.vn';credit.setAttribute('aria-hidden','true');frame.append(credit);
});
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
