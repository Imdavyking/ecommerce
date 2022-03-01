<?php
if (!session_id()) session_start();
if ($_SESSION['csrf_token'] !== $_GET['csrf_token']) die(header("Location: /"));
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/utils/db.php";
$stmt  = $pdo->prepare("DELETE FROM login_users WHERE login_cookie = ?");
$stmt->execute([$_COOKIE['userVerified']]);

if (isset($_COOKIE['userVerified']))
  setcookie('userVerified', "", time() - 60 * 60 * 24 * 365, "/", "", true, true);
session_unset();
session_destroy();

die(header("Location: /"));
