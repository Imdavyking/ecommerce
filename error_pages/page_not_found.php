<?php

declare(strict_types=1);
http_response_code(404);
$constantVar = function ($name) {
  return constant($name);
};
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$root = $_SERVER['DOCUMENT_ROOT'];
if (
  !isset($_SERVER['REDIRECT_STATUS'])
  || (int) $_SERVER['REDIRECT_STATUS'] !== 404
) die(header('Location:/'));
require_once "{$constantVar('root')}/includes/common_data.inc.php";
outPutMinified('htmlStart');
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta name="robots" content="noindex, nofollow">
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/page_not_found.min.css') ?>">
  <script src="<?= $CACHE_BUSTER('/js/page_not_found.min.js') ?>" defer></script>
  <title>404 | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
</head>

<body>
  <div id="container">
    <div class="content">
      <h2>404</h2>
      <h4>Oops! Page not found</h4>
      <p>The page you were looking for doesn't exist. You may have mistyped the address or the page may have moved.</p>
      <a href="/">Back To Home</a>
    </div>
  </div>
</body>

</html>