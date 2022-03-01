<?php
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/utils/db.php";

$isLoggedIn = false;
$loginResult = [];
$userDetails = null;

if (isset($_COOKIE['userVerified'])) {
  $stmt  = $pdo->prepare("SELECT user_id,ip_address,user_agent,userName,email,phone FROM login_users JOIN users on `users`.`id` = `login_users`.`user_id` WHERE login_cookie = ? && ip_address = ? && user_agent = ?");
  $stmt->execute([$_COOKIE['userVerified'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']]);
  $loginResult = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($loginResult) $isLoggedIn = true;
}
