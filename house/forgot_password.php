<?php
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/includes/checkLogin.php";
require_once "{$constantVar('root')}/includes/common_data.inc.php";

outPutMinified('htmlStart');
if ($isLoggedIn) die("<script nonce='{$_SESSION['nonce']}'>history.go(-1)</script>");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>

  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/forgot_password.min.css') ?>" />
  <script src="<?= $CACHE_BUSTER('/js/forgot_password.min.js') ?>" defer></script>

  <title>Forgot Password | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="#" class="sign-in-form get_reset_code" method="POST">
          <h2 class="title">Get Reset Code</h2>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="get_reset_email" class="get_reset_email" aria-label="email" />
          </div>
          <button type="submit" class="btn solid">Get Reset Code</button>
        </form>

        <form action="#" class="sign-up-form change_password_form" method="POST">
          <h2 class="title">Change Password</h2>
          <div class="input-field">
            <i class="fas fa-key"></i>
            <input type="text" placeholder="Reset Code" name="reset_code" class="reset_code" required aria-label="reset code" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="change_password" class="change_password" required aria-label="password" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="confirm_change_password" class="confirm_change_password" required aria-label="confirm password" />
          </div>
          <button type="submit" class="btn">Change Password</button>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>We forget at times</h3>
          <p>
            Enter your email and get a password reset code
          </p>
        </div>
        <img src="/img/forgot_password.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Change your password</h3>
          <p>
            Password is a very important part of security, keep it safe.
          </p>
        </div>
        <img src="/img/secure_login.svg" class="image" alt="" />
      </div>
    </div>
  </div>
</body>

</html>