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
$constantVar = function ($name) {
  return constant($name);
};
$data_obj = json_decode(file_get_contents("php://input"));
require_once "{$constantVar('root')}/api/csrf_check.php";
require_once "{$constantVar('root')}/utils/db.php";
require_once "{$constantVar('root')}/includes/common_data.inc.php";

$stmt = $pdo->prepare("SELECT email FROM forgot_password  WHERE reset_code = ?");
$stmt->execute([$data_obj->reset_code]);
$email  = $stmt->fetch(PDO::FETCH_ASSOC)['email'];

if ($email === null) die(json_encode([
  'status' => 'error',
  'error' => 'Invalid reset code'
]));

if (strlen(trim($data_obj->change_password)) >= 6) {
  $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
  $stmt->execute([password_hash($data_obj->change_password, PASSWORD_BCRYPT), $email]);
  $stmt = $pdo->prepare("DELETE FROM forgot_password WHERE reset_code = ?");
  $stmt->execute([$data_obj->reset_code]);
  die(json_encode([
    'status' => 'success'
  ]));
}
