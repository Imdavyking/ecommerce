<?php

declare(strict_types=1);
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("$root/includes/common_data.inc.php");
if (makeNotFoundIfNotRequestUrl('/robots.txt')) die(require_once('error.php'));
header('Content-Type: text/plain; charset=utf-8');
?>
User-agent: *
Disallow: /vendor
Disallow: /webfonts
Disallow: /api
Disallow: /partials
Disallow: /admin
Sitemap: <?= COMPANY_WEBSITE_URL; ?>/sitemap.xml