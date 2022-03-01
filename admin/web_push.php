<?php

declare(strict_types=1);
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("$root/includes/common_data.inc.php");
outPutMinified('htmlStart');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/web_push.min.css') ?>">
  <title>WebPush<?= TITLE_HEADING; ?></title>
</head>

<body>
  <div class="container">
    <div class="nav-whitespace"></div>
    <div id="pushFormContainer">
      <div class="pushInformation">
        Send push Notification to all users of the website who enabled Notifications
      </div>
      <form id="pushForm">
        <input type="text" name="title" class="title" placeholder="Title" aria-label="title" required>
        <input type="url" name="icon" placeholder="Icon URL" aria-label="icon">
        <input type="url" name="image" placeholder="Image URL" aria-label="image">
        <input type="text" name="tag" placeholder="Tag" aria-label="tag">
        <textarea name="body" class="body" placeholder="Body" cols="30" rows="10" aria-label="body"></textarea>
        <button type="submit" id="use-push">Subscribe to Notification</button>
        <button type="submit" class="pusher">Send push Notification</button>
      </form>
    </div>
    <div class="error"></div>
  </div>
  <script src="<?= $CACHE_BUSTER('/js/web_push.min.js') ?>"></script>
</body>

</html>
<?php outPutMinified('htmlEnd'); ?>