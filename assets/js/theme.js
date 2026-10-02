document.body.classList.add('theme-ready');

(function(){
  const toggle=document.querySelector('.ma-toggle');
  const nav=document.querySelector('.ma-nav');
  toggle?.addEventListener('click',()=>{
    const open=document.body.classList.toggle('ma-menu-open');
    toggle.setAttribute('aria-expanded',open?'true':'false');
    toggle.textContent=open?'×':'☰';
  });
  nav?.querySelectorAll('.ma-submenu-toggle').forEach(btn=>btn.addEventListener('click',(e)=>{
    e.preventDefault(); e.stopPropagation();
    const item=btn.closest('.ma-menu-item');
    const open=item?.classList.toggle('is-submenu-open');
    btn.setAttribute('aria-expanded',open?'true':'false');
  }));
  nav?.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{
    document.body.classList.remove('ma-menu-open');
    toggle?.setAttribute('aria-expanded','false');
    if(toggle) toggle.textContent='☰';
    nav?.querySelectorAll('.is-submenu-open').forEach(item=>item.classList.remove('is-submenu-open'));
    nav?.querySelectorAll('.ma-submenu-toggle').forEach(btn=>btn.setAttribute('aria-expanded','false'));
  }));

  const slides=[...document.querySelectorAll('.ma-slide')];
  const dots=[...document.querySelectorAll('.ma-dots button')];
  const current=document.querySelector('.ma-current');
  let index=0,timer;
  function show(i){
    if(!slides.length)return;
    index=(i+slides.length)%slides.length;
    slides.forEach((el,n)=>el.classList.toggle('is-active',n===index));
    dots.forEach((el,n)=>el.classList.toggle('is-active',n===index));
    if(current) current.textContent=String(index+1).padStart(2,'0');
  }
  function restart(){clearInterval(timer);timer=setInterval(()=>show(index+1),7000)}
  document.querySelector('.ma-next')?.addEventListener('click',()=>{show(index+1);restart()});
  document.querySelector('.ma-prev')?.addEventListener('click',()=>{show(index-1);restart()});
  dots.forEach((d,i)=>d.addEventListener('click',()=>{show(i);restart()}));
  if(slides.length)restart();

  const main=document.getElementById('maGalleryMain');
  const title=document.getElementById('maGalleryTitle');
  const meta=document.getElementById('maGalleryMeta');
  document.querySelectorAll('.ma-thumb').forEach(btn=>btn.addEventListener('click',()=>{
    if(!main)return;
    main.classList.add('is-changing');
    setTimeout(()=>{
      main.src=btn.dataset.image||'';
      main.alt=btn.dataset.title||'';
      if(title)title.textContent=btn.dataset.title||'';
      if(meta)meta.textContent=btn.dataset.meta||'';
      document.querySelectorAll('.ma-thumb').forEach(x=>x.classList.remove('is-active'));
      btn.classList.add('is-active');
      main.classList.remove('is-changing');
    },180);
  }));
})();

// v2.74.62 — smooth back-to-top
(function(){
  const top=document.querySelector('.ma-back-top');
  if(!top)return;
  const toggle=()=>top.classList.toggle('is-visible',window.scrollY>420);
  toggle();
  window.addEventListener('scroll',toggle,{passive:true});
  top.addEventListener('click',e=>{e.preventDefault();window.scrollTo({top:0,behavior:'smooth'});});
})();

// v2.74.61 — smooth in-page navigation
document.querySelectorAll('a[href^="#"]').forEach(a=>a.addEventListener('click',e=>{
  const id=a.getAttribute('href');
  if(!id||id==='#')return;
  const target=document.querySelector(id);
  if(target){e.preventDefault();target.scrollIntoView({behavior:'smooth',block:'start'});}
}));


// Premium scroll polish
(function(){
  const header=document.querySelector('.ma-header');
  const progress=document.createElement('div'); progress.className='ma-scroll-progress'; document.body.appendChild(progress);
  const update=()=>{
    const max=document.documentElement.scrollHeight-window.innerHeight;
    const ratio=max>0?window.scrollY/max:0;
    progress.style.width=(ratio*100)+'%';
    header?.classList.toggle('is-scrolled',window.scrollY>24);
  };
  update(); window.addEventListener('scroll',update,{passive:true});
  const reveal=[...document.querySelectorAll('.ma-reveal')];
  if('IntersectionObserver' in window){
    const io=new IntersectionObserver(entries=>entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('is-visible');io.unobserve(e.target)}}),{threshold:.14});
    reveal.forEach(el=>io.observe(el));
  }else reveal.forEach(el=>el.classList.add('is-visible'));
})();


// v2.74.59 — custom language dropdown; preserves the previous trigger appearance and avoids native iOS sheet
(function(){
  const wrap=document.querySelector('.ma-language');
  const trigger=wrap?.querySelector('.ma-language-trigger');
  const menu=wrap?.querySelector('.ma-language-menu');
  if(!wrap||!trigger||!menu)return;
  const close=()=>{wrap.classList.remove('is-open');trigger.setAttribute('aria-expanded','false');};
  trigger.addEventListener('click',(e)=>{e.preventDefault();e.stopPropagation();const open=!wrap.classList.contains('is-open'); if(open){wrap.classList.add('is-open');trigger.setAttribute('aria-expanded','true');}else close();});
  menu.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>close()));
  document.addEventListener('click',(e)=>{if(!wrap.contains(e.target))close();});
  document.addEventListener('keydown',(e)=>{if(e.key==='Escape')close();});
})();
