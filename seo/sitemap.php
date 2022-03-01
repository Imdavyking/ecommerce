<?php

declare(strict_types=1);
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("$root/includes/common_data.inc.php");
if (makeNotFoundIfNotRequestUrl('/sitemap.xml')) die(require_once("$root/blog/error.php"));
header('Content-Type: application/xml; charset=utf-8');
DEFINE('WEB_PAGES', [
  '/',
  '/house/product',
  '/house/search',
  '/house/cart',
  '/house/login',
  '/house/forgot_password',
  '/house/terms'
]);

outPutMinified('htmlStart');
?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php foreach (WEB_PAGES as $webPage) : ?>
    <url>
      <loc><?= COMPANY_WEBSITE_URL; ?><?= $webPage ?></loc>
    </url>
  <?php endforeach; ?>
</urlset>