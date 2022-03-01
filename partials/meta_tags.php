<?php require_once "{$constantVar('root')}/includes/common_data.inc.php"; ?>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="referrer" content="strict-origin-when-cross-origin" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="mobile-web-app-capable" content="yes" />
<meta name="theme-color" content="<?= $CONSTANT('COMPANY_PWA_THEME_COLOR') ?>" />
<meta name="msapplication-navbutton-color" content="<?= $CONSTANT('COMPANY_PWA_THEME_COLOR') ?>" />
<meta name="apple-mobile-web-app-status-bar-style" content="<?= $CONSTANT('COMPANY_PWA_THEME_COLOR') ?>" />
<meta name="twitter:url" property="og:url" itemprop="url" content="<?= $CONSTANT('COMPANY_WEBSITE_URL') ?><?= $_SERVER['REQUEST_URI'] ?>">
<meta name="twitter:image" property="og:image" itemprop="image" content="<?= $CONSTANT('COMPANY_OPEN_GRAPH_IMAGE_URL') ?>">
<meta name="twitter:description" property="og:description" itemprop="description" content="<?= $CONSTANT('COMPANY_DESCRIPTION') ?>">
<meta name="description" content="<?= $CONSTANT('COMPANY_DESCRIPTION') ?>">
<meta name="twitter:title" property="og:title" itemprop="name" content="<?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?>">
<meta name="twitter:card" content="summary">
<meta name="csrf_token" id="csrf_token" content="<?= $_SESSION['csrf_token'] ?>">
<meta name="vapid_publicKey" id="vapid_publicKey" content="<?= $userConfig['vapid_PublicKey'] ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?>">
<meta property="og:locale" content="en_NG" />
<link rel="preload" as="font" href="/webfonts/fa-solid-900.woff2" crossorigin="anonymous">
<link rel="preload" as="font" href="/webfonts/fa-brands-400.woff2" crossorigin="anonymous">
<link rel="preload" as="font" href="/webfonts/google_archivo.woff2" crossorigin="anonymous">
<link rel="shortcut icon" href="/logo.png" />
<link rel="apple-touch-icon" href="/img/pwa_apple_icon_180.png" />
<link rel="canonical" href="<?= $CONSTANT('COMPANY_WEBSITE_URL') ?><?= $_SERVER['REQUEST_URI'] ?>" />


<link rel="stylesheet" href="/vendor/sweetalert/sweetalert.min.css" />
<link rel="stylesheet" href="/vendor/glide/glide.core.min.css">
<link rel="stylesheet" href="/vendor/glide/glide.theme.min.css">
<link rel="stylesheet" href="/vendor/font_awesome/css/all.min.css" />
<link rel="stylesheet" href="/vendor/aos/aos.min.css" />

<style nonce="<?= $_SESSION['nonce'] ?>">
  #loading_network {
    width: 20px;
    object-fit: contain;
  }
</style>

<script src="/vendor/regenerator-runtime/regenerator-runtime.min.js" defer></script>
<script src="/vendor/sweetalert/sweetalert.min.js" defer></script>
<script src="/vendor/glide/glide.min.js" defer></script>
<script src="/vendor/aos/aos.min.js" defer></script>
<script src="/vendor/slider/slider.min.js" defer></script>
<script src="/vendor/kitConfig/kitConfig.min.js" defer></script>
<script src="/vendor/intlTelInput/intlTelInput.min.js" defer></script>
<script src="/vendor/intlTelInput/utils.min.js" defer></script>
<script nonce="<?= $_SESSION['nonce'] ?>">
  addEventListener('DOMContentLoaded', function() {
    AOS.init({
      disable: false,
      startEvent: 'load'
    })
  });
</script>
<script type="application/json" id="cache-busting-images" nonce="<?= $_SESSION['nonce'] ?>">
  <?= file_get_contents("{$constantVar('root')}/json/cacheBuster.min.json") ?>
</script>