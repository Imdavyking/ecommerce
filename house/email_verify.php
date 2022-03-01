<?php
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
$data_obj = json_decode(file_get_contents("php://input"));

require_once "{$constantVar('root')}/includes/common_data.inc.php";

if (!isset($_GET['v']) || !isset($_GET['action'])) die("<script nonce='{$_SESSION['nonce']}'>history.go(-1)</script>");

$result = null;

$updateTableToShowVerified  = function ($tableName) use ($constantVar) {
  require_once "{$constantVar('root')}/utils/db.php";
  $stmt = $GLOBALS['pdo']->prepare("SELECT count(*) as number_of_users FROM $tableName  WHERE v_code = ? && verified = '0'");
  $stmt->execute([$_GET['v']]);

  $GLOBALS['result'] = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($GLOBALS['result']['number_of_users'] === 1) {
    $stmt = $GLOBALS['pdo']->prepare("UPDATE $tableName SET verified = '1' WHERE v_code = ?");
    $stmt->execute([$_GET['v']]);
    $stmt = $GLOBALS['pdo']->prepare("UPDATE $tableName SET v_code = null WHERE v_code = ?");
    $stmt->execute([$_GET['v']]);
  }
};

if ($_GET['action'] === 'subscribe_to_newletter')
  $updateTableToShowVerified('newsletter_users');
else if ($_GET['action'] === 'signup')
  $updateTableToShowVerified('users');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/style.min.css') ?>" />
  <title>Verify your email | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
</head>

<body>
  <?php if ($result['number_of_users'] === 1) : ?>
    <script nonce="<?= $_SESSION['nonce'] ?>">
      addEventListener('DOMContentLoaded', () => {
        swal({
          title: 'Email verification successful',
          text: 'Thank you for registrating your email with us',
          icon: 'success'
        }).then(() => {
          window.location = '/';
        });
      });
    </script>
  <?php else : ?>
    <script nonce="<?= $_SESSION['nonce'] ?>">
      addEventListener('DOMContentLoaded', () => {
        swal({
          title: 'Email verification failed',
          text: 'Please try again later',
          icon: 'error'
        }).then(() => {
          window.location = '/';
        });
      });
    </script>
  <?php endif; ?>
</body>

</html>