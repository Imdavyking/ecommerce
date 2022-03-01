<?php
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/utils/db.php";
if (!isset($_GET['r'])) {
  die('Please an redirection url needed');
}
$stmt = $pdo->prepare('SELECT actualLink FROM linkshortener WHERE BINARY shortLink = ? LIMIT 1');
$stmt->execute([trim($_GET['r'])]);
$actualLink = $stmt->fetch(PDO::FETCH_ASSOC)['actualLink'];
if ($stmt->rowCount() === 0) {
  $_SERVER['REDIRECT_STATUS'] = 404;
  require_once "{$constantVar('root')}/error_pages/page_not_found.php";
} else if ($_SERVER['REQUEST_URI'][strlen($_SERVER['REQUEST_URI']) - 1] === '+')
  die($actualLink);
else die(header("Location:{$actualLink}"));
