(() => {
 'use strict';
 const config=window.tp48Tracking;
 if (!config || window.tp48TrackingBound) return;
 window.tp48TrackingBound=true;
 const pageType=['home','contact','other'].includes(config.pageType) ? config.pageType : 'other';
 const send=(name,params)=>{
  if (typeof window.gtag!=='function') return;
  // Explicit allowlist only: never pass form inputs, link URLs or visible text.
  window.gtag('event',name,{send_to:config.measurementId,page_type:pageType,...params});
 };
 document.addEventListener('click',event=>{
  const link=event.target.closest?.('a[data-tp48-contact]');
  if (!link) return;
  const channel=link.dataset.tp48Contact;
  if (!['phone','zalo','messenger'].includes(channel)) return;
  send(`click_${channel}`,{placement:'footer'});
 });
 document.addEventListener('wpcf7mailsent',event=>{
  if (!Number(config.formId) || Number(event.detail?.contactFormId)!==Number(config.formId)) return;
  send('generate_lead',{form_name:'contact_registration',form_location:pageType});
 });
})();
