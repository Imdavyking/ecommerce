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

  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/login.min.css') ?>" />
  <link rel="stylesheet" href="/vendor/intlTelInput/intlTelInput.min.css" />
  <script src="<?= $CACHE_BUSTER('/js/login.min.js') ?>" defer></script>

  <title>Sign in | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="#" class="sign-in-form" method="POST">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="signIn-email" aria-label="email" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="signIn-password" aria-label="password" />
            <i class="fas fa-eye show-password"></i>

          </div>

          <button type="submit" class="btn solid">Login</button>

          <a href="/house/forgot_password" class="forgot_password_link">forgot password?</a>
        </form>

        <form action="#" class="sign-up-form" method="POST">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Full Name" name="signUp-username" required aria-label="username" />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="signUp-email" required aria-label="email" />
          </div>
          <div class="input-field">
            <i class="fas fa-phone"></i>
            <input type="tel" id="phone" placeholder="Phone" name="signUp-phone" required aria-label="phone" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="signUp-password-one" required aria-label="password" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="signUp-password-two" required aria-label="confirm password" />
          </div>
          <button type="submit" class="btn">Sign up</button>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here ?</h3>
          <p>
            Join us, and get products at discount rate
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Sign up
          </button>
        </div>
        <img src="/img/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>
            Hop in and see lastest products we have for you.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="/img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>
</body>

</html>