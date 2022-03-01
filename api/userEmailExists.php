<?php
header('Content-Type:application/json');
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  die(json_encode([
    'status' => 'error',
    'error' => 'access this page with method post'
  ]));
}
$data_obj = json_decode(file_get_contents("php://input"));
require_once "{$constantVar('root')}/api/csrf_check.php";

if (!isset($data_obj->email)) {
  http_response_code(400);
  die(json_encode([
    'error' => 'email post data is empty'
  ]));
}
require_once "{$constantVar('root')}/utils/db.php";
$stmt  = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$data_obj->email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
die(json_encode([
  'exists' => $user ? true : false
]));
