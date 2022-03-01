<?php
header('Content-Type:application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  die(json_encode([
    'status' => 'error',
    'error' => 'access this page with method post'
  ]));
}
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$shortLinkRewriteFromHtacess = "{$_SERVER['SERVER_NAME']}/r/";
$constantVar = function ($name) {
  return constant($name);
};
require_once("{$constantVar('root')}/includes/common_data.inc.php");
require_once "{$constantVar('root')}/utils/db.php";

if (isset($_GET['url']) && filter_var($_GET['url'], FILTER_VALIDATE_URL)) {
  $stmt = $pdo->prepare('SELECT shortLink FROM linkshortener WHERE actualLink = ? LIMIT 1');
  $stmt->execute([trim($_GET['url'])]);
  if ($stmt->rowCount() === 0) {
    $unique = random_str(8);
    $stmt = $pdo->prepare('INSERT INTO linkshortener(actualLink,shortLink) VALUES (?,?)');
    $stmt->execute([$_GET['url'], $unique]);
    die(json_encode([
      'status' => 'success',
      'message' => "https://{$shortLinkRewriteFromHtacess}{$unique}",
      'shortened' => true
    ]));
  } else {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    die(json_encode([
      'status' => 'success',
      'message' => "https://{$shortLinkRewriteFromHtacess}{$result['shortLink']}",
      'shortened' => true
    ]));
  }
} else {
  http_response_code(400);
  die(json_encode([
    'status' => 'error',
    'message' => "Invalid url or url not provided",
    'shortened' => false
  ]));
}
