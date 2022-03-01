<?php
header('Content-Type:application/json');
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/includes/checkLogin.php";
die(json_encode([
  'isLoggedIn' => $isLoggedIn,
  'userId' => $loginResult['user_id'],
  'email' => $loginResult['email']
]));
