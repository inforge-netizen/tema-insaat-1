<?php
$settings=$settings??[];
$siteName=$settings['site_name']??'Monument Atelier';
$menus=$menus??[];
// Menüleri tema ile sınırlama: admin panelinden eklenen yeni menüler ve alt menüler
// canlı sitede de görünmelidir. Aksi halde tema ilk kurulumdaki menüleri gösterir.
$allMenus = $menus;
$topMenus=array_values(array_filter($allMenus,fn($m)=>(int)($m['parent_id']??0)===0));
$childrenByParent=[];
foreach($allMenus as $m){$pid=(int)($m['parent_id']??0);if($pid>0)$childrenByParent[$pid][]=$m;}
$seen=[];$renderMenus=[];
foreach($topMenus as $m){
  $label=trim((string)($m['title']??''));
  $key=mb_strtolower(preg_replace('/\s+/u',' ',$label));
  if($key==='anasayfa'||$key==='ana sayfa'){
    if(isset($seen['anasayfa']))continue;
    $m['url']=base_url('');$seen['anasayfa']=true;
  }
  $url=(string)($m['url']??'#');$ukey=$key.'|'.$url;
  if(isset($seen[$ukey]))continue;
  $seen[$ukey]=true;$renderMenus[]=$m;
}

require_once CORE_PATH.'/LanguageManager.php';
$languageUrl=static function(string $code):string{
  $url=current_url();
  $url=preg_replace('/([?&])lang=[^&]*/i','$1',$url);
  $url=preg_replace('/[?&]$/','',$url);
  return $url.(str_contains($url,'?')?'&':'?').'lang='.rawurlencode($code);
};
$enabledLanguages=LanguageManager::enabled();
$primary=$settings['theme_insaat-monument_primary_color']??'#b89563';
$secondary=$settings['theme_insaat-monument_secondary_color']??'#11100e';
$description=trim((string)($metaDescription??$settings['seo_description']??''));
$canonicalUrl=$canonicalUrl??current_url();$title=$siteTitle??$siteName;
?>
<!doctype html><html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=htmlspecialchars($title)?></title><?php if($description):?><meta name="description" content="<?=htmlspecialchars($description)?>"><?php endif;?><meta name="robots" content="<?=htmlspecialchars($robots??'index, follow')?>"><link rel="canonical" href="<?=htmlspecialchars($canonicalUrl)?>"><meta property="og:title" content="<?=htmlspecialchars($title)?>"><meta property="og:description" content="<?=htmlspecialchars($description)?>"><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&family=Manrope:wght@400;500;600;700&display=swap"><link rel="stylesheet" href="<?=base_url('themes/insaat-monument/assets/css/theme.css')?>?v=2.74.79"><style>html{background:#11100e}body{opacity:0}:root{--gold:<?=$primary?>;--ink:<?=$secondary?>}</style></head><body>
<header class="ma-header">
<a class="ma-logo" href="<?=base_url('')?>"><span>MA</span><strong><?=htmlspecialchars($siteName)?></strong></a>
<button class="ma-toggle" type="button" aria-label="Menüyü aç" aria-expanded="false">☰</button>
<nav class="ma-nav" aria-label="Ana menü">
<?php
$renderMenuTree = function(array $items, int $level = 0) use (&$renderMenuTree, $childrenByParent): void {
    foreach($items as $m):
        $label=trim((string)($m['title']??''));
        $key=mb_strtolower($label);
        $url=($key==='anasayfa'||$key==='ana sayfa')?base_url(''):(string)($m['url']??'#');
        $id=(int)($m['id']??0);
        $children=$childrenByParent[$id]??[];
        ?>
        <div class="ma-menu-item<?=count($children)?' has-children':''?><?= $level>0?' ma-menu-subitem':'' ?>">
          <a class="ma-menu-link" href="<?=htmlspecialchars($url,ENT_QUOTES,'UTF-8')?>" target="<?=htmlspecialchars((string)($m['target']??'_self'),ENT_QUOTES,'UTF-8')?>"><?=htmlspecialchars($label,ENT_QUOTES,'UTF-8')?></a><?php if($children): ?><button class="ma-submenu-toggle" type="button" aria-label="Alt menüyü aç/kapat" aria-expanded="false"><span></span></button><?php endif; ?>
          <?php if($children): ?><div class="ma-submenu"><?php $renderMenuTree($children,$level+1); ?></div><?php endif; ?>
        </div>
        <?php
    endforeach;
};
$renderMenuTree($renderMenus);
?>
</nav>
<div class="ma-socials" aria-label="Sosyal medya">
  <a href="<?=htmlspecialchars($settings['instagram']??'#',ENT_QUOTES,'UTF-8')?>" aria-label="Instagram" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.4" cy="6.6" r="1"></circle></svg></a>
  <a href="<?=htmlspecialchars($settings['twitter']??($settings['x']??'#'),ENT_QUOTES,'UTF-8')?>" aria-label="X / Twitter" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4l14 16M19 4L5 20"></path></svg></a>
  <a href="<?=htmlspecialchars($settings['youtube']??'#',ENT_QUOTES,'UTF-8')?>" aria-label="YouTube" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 8.2a2.8 2.8 0 0 0-2-2C17.2 5.7 12 5.7 12 5.7s-5.2 0-7 .5a2.8 2.8 0 0 0-2 2C2.5 10 2.5 12 2.5 12s0 2 .5 3.8a2.8 2.8 0 0 0 2 2c1.8.5 7 .5 7 .5s5.2 0 7-.5a2.8 2.8 0 0 0 2-2c.5-1.8.5-3.8.5-3.8s0-2-.5-3.8Z"></path><path d="m10 9 5 3-5 3V9Z"></path></svg></a>
</div>
<div class="ma-header-actions">
<?php if(count($enabledLanguages)>1): ?>
<div class="ma-language">
  <button class="ma-language-trigger" type="button" aria-expanded="false" aria-haspopup="listbox" aria-label="Dil seçimi">
    <span><?=htmlspecialchars(strtoupper(LanguageManager::current()),ENT_QUOTES,'UTF-8')?></span><i aria-hidden="true"></i>
  </button>
  <div class="ma-language-menu" role="listbox" aria-label="Dil seçenekleri">
    <?php foreach($enabledLanguages as $langCode): ?>
      <a role="option" class="ma-language-option<?=LanguageManager::current()===$langCode?' is-active':''?>" aria-selected="<?=LanguageManager::current()===$langCode?'true':'false'?>" href="<?=htmlspecialchars($languageUrl($langCode),ENT_QUOTES,'UTF-8')?>"><?=htmlspecialchars(strtoupper($langCode),ENT_QUOTES,'UTF-8')?></a>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>
<a class="ma-header-cta" href="<?=base_url('monument-iletisim')?>">PROJE KONUŞALIM ↗</a>
</div>
</header>
