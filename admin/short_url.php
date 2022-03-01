<?php

declare(strict_types=1);
if (!session_id()) session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("$root/includes/common_data.inc.php");
outPutMinified('htmlStart');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/short_url.min.css') ?>">
  <title>ShortUrl<?= TITLE_HEADING; ?></title>
</head>

<body>
  <div class="container">
    <div class="nav-whitespace"></div>
    <div class="short-url-container">
      <div class="short-url-info">
        Shorten URL links to better visit and feedback
      </div>
      <form id="link-shortener" action="">
        <input type="url" pattern="https?://.+" title="URL should start with http:// or https://" class="shortenurl-url ignore-reset" name="url">
        <button type="submit" class="shortenurl-submit">Shorten URL</button>
      </form>
    </div>
    <b class="shortened-link-result"></b>

  </div>
  <script src="<?= $CACHE_BUSTER('/js/short_url.min.js') ?>" defer></script>
</body>

</html>