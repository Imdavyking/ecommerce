<?php

declare(strict_types=1);
http_response_code(403);
$constantVar = function ($name) {
  return constant($name);
};
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$root = $_SERVER['DOCUMENT_ROOT'];
if (
  !isset($_SERVER['REDIRECT_STATUS'])
  || (int) $_SERVER['REDIRECT_STATUS'] !== 403
) die(header('Location:/'));
require_once "{$constantVar('root')}/includes/common_data.inc.php";
outPutMinified('htmlStart');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="robots" content="noindex, nofollow">
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
  <title>403 | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/page_forbidden.min.css') ?>">
  <script src="<?= $CACHE_BUSTER('/js/page_forbidden.min.js') ?>" defer></script>
</head>

<body translate="no">
  <div class="container">
    <h1>
      4
      <div class="lock">
        <div class="top"></div>
        <div class="bottom"></div>
      </div>
      3
    </h1>
    <p>Access denied</p>
  </div>
</body>

</html>