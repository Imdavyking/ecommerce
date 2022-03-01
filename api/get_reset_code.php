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

if (!filter_var($data_obj->email, FILTER_VALIDATE_EMAIL))
  die(json_encode([
    'status' => 'error',
    'error' => 'Invalid email'
  ]));

$random_token = random_str(6, true);

ob_start();
require_once "{$constantVar('root')}/partials/forgot_password_template.php";
$result = ob_get_clean();

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
if (mail($data_obj->email, 'Forgot Password', $result, $headers)) {
  $stmt = $pdo->prepare("SELECT COUNT(*) as email_count FROM forgot_password WHERE email = ?");
  $stmt->execute([$data_obj->email]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result['email_count'] === 1) {
    $stmt = $pdo->prepare("UPDATE forgot_password SET reset_code = ? WHERE email = ?");
    $stmt->execute([$random_token, $data_obj->email]);
  } else {
    $stmt = $pdo->prepare("INSERT INTO forgot_password (email,reset_code) VALUES (?,?)");
    $stmt->execute([$data_obj->email, $random_token]);
  }
  die(json_encode([
    'status' => 'success'
  ]));
} else die(json_encode([
  'status' => 'error',
  'error' => 'Error sending reset code to email'
]));
