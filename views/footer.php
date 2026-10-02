<?php
require_once CORE_PATH.'/LanguageManager.php';
$settings=$settings??[];
$footerThemeRaw=trim((string)($settings['theme_insaat-monument_settings']??''));
$footerTheme=$footerThemeRaw!==''?json_decode($footerThemeRaw,true):[];
if(!is_array($footerTheme))$footerTheme=[];
$footerTheme=LanguageManager::themeSettings('insaat-monument',LanguageManager::current(),$footerTheme);
$footerSection=$footerTheme['sections']['footer']??[];
$footerKicker=trim((string)($footerSection['kicker']??''))?:'MONUMENT ATELIER';
$footerTitle=trim((string)($footerSection['title']??''))?:'Yapının karakteri detaylarda başlar.';
$footerPhone = trim((string)($settings['contact_phone'] ?? '')) ?: '+90 212 000 00 00';
$footerEmail = trim((string)($settings['contact_email'] ?? '')) ?: 'info@monumentatelier.com';
$footerAddress = trim((string)($settings['contact_address'] ?? '')) ?: 'İstanbul, Türkiye';
?>
<footer class="ma-footer">
  <div class="ma-footer-brand">
    <span class="ma-kicker"><?=htmlspecialchars($footerKicker,ENT_QUOTES,'UTF-8')?></span>
    <h2><?=nl2br(htmlspecialchars($footerTitle,ENT_QUOTES,'UTF-8'))?></h2>
  </div>
  <div class="ma-footer-columns">
    <div class="ma-footer-contact">
      <span class="ma-footer-label">İLETİŞİM</span>
      <a href="tel:<?=htmlspecialchars(preg_replace('/[^0-9+]/','',$footerPhone),ENT_QUOTES,'UTF-8')?>"><?=htmlspecialchars($footerPhone,ENT_QUOTES,'UTF-8')?></a>
      <a href="mailto:<?=htmlspecialchars($footerEmail,ENT_QUOTES,'UTF-8')?>"><?=htmlspecialchars($footerEmail,ENT_QUOTES,'UTF-8')?></a>
      <p><?=htmlspecialchars($footerAddress,ENT_QUOTES,'UTF-8')?></p>
      <div class="ma-footer-socials" aria-label="Sosyal medya">
        <a href="<?=htmlspecialchars($settings['instagram']??'#',ENT_QUOTES,'UTF-8')?>" target="_blank" rel="noopener noreferrer">Instagram</a>
        <a href="<?=htmlspecialchars($settings['twitter']??($settings['x']??'#'),ENT_QUOTES,'UTF-8')?>" target="_blank" rel="noopener noreferrer">Twitter</a>
        <a href="<?=htmlspecialchars($settings['youtube']??'#',ENT_QUOTES,'UTF-8')?>" target="_blank" rel="noopener noreferrer">YouTube</a>
      </div>
    </div>
    <div class="ma-footer-sitemap">
      <span class="ma-footer-label">SİTE HARİTASI</span>
      <nav aria-label="Site haritası">
      <?php
      $footerMenus=$menus??[];
      $footerSeen=[];
      foreach($footerMenus as $fm):
        if((int)($fm['parent_id']??0)!==0) continue;
        $ft=trim((string)($fm['title']??''));
        $fk=mb_strtolower(preg_replace('/\s+/u',' ',$ft));
        if(isset($footerSeen[$fk])) continue;
        $footerSeen[$fk]=true;
        $fu=($fk==='anasayfa'||$fk==='ana sayfa')?base_url(''):(string)($fm['url']??'#');
      ?>
        <a href="<?=htmlspecialchars($fu,ENT_QUOTES,'UTF-8')?>"><?=htmlspecialchars($ft,ENT_QUOTES,'UTF-8')?></a>
      <?php endforeach; ?>
      </nav>
    </div>
  </div>
</footer>
<a class="ma-back-top" href="#ma-top" aria-label="Sayfanın başına dön"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 14 12 8l6 6"></path></svg></a>
<a class="ma-whatsapp" href="https://wa.me/<?=htmlspecialchars(preg_replace('/[^0-9]/','',(string)($settings['whatsapp']??'905320000000')),ENT_QUOTES,'UTF-8')?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp ile iletişim"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.6 0 .4 5.2.4 11.7c0 2.1.6 4.1 1.6 5.8L.3 24l6.7-1.7c1.6.9 3.3 1.3 5.1 1.3 6.4 0 11.6-5.2 11.6-11.7 0-3.1-1.2-6.1-3.2-8.4ZM12.1 21.5c-1.6 0-3.2-.4-4.6-1.2l-.3-.2-4 .9 1-3.9-.2-.3a9.7 9.7 0 1 1 8.1 4.7Zm5.3-7.3c-.3-.2-1.8-.9-2.1-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-1 1.2-.2.2-.4.2-.7.1-.3-.2-1.3-.5-2.5-1.6-.9-.8-1.6-1.8-1.8-2.1-.2-.3 0-.5.1-.7l.5-.6c.2-.2.2-.3.3-.5.1-.2 0-.4 0-.6-.1-.2-.7-1.7-.9-2.3-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.1 1-1.1 2.5s1.1 2.9 1.2 3.1c.2.2 2.1 3.3 5.2 4.6.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.1-1.4-.1-.1-.3-.2-.6-.3Z"></path></svg></a>
<div class="ma-copy ma-copy-protected" data-protected="true" data-protection="theme-permission">© <?=date('Y')?> <a href="https://tasarimsk.com" target="_blank" rel="noopener noreferrer">Tasarım Sk</a></div><script src="<?=base_url('themes/insaat-monument/assets/js/theme.js')?>"></script></body></html>