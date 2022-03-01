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

$random_token = sha1(random_bytes(256));
$action = 'subscribe_to_newletter';

ob_start();
require_once "{$constantVar('root')}/partials/email_verify_template.php";
$result = ob_get_clean();


$stmt = $pdo->prepare("SELECT count(*) as total_item FROM newsletter_users WHERE email = ?");
$stmt->execute([$data_obj->email]);
if ($stmt->fetch(PDO::FETCH_ASSOC)['total_item'] !== 0) die(json_encode([
  'status' => 'error',
  'error' => 'Email Subscribed Already'
]));

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
if (mail($data_obj->email, 'Email Verification', $result, $headers)) {
  $stmt = $pdo->prepare("INSERT INTO newsletter_users (email,v_code) VALUES (?,?)");
  $stmt->execute([$data_obj->email, $random_token]);
  die(json_encode([
    'status' => 'success'
  ]));
} else die(json_encode([
  'status' => 'error',
  'error' => 'Error sending verification code to email'
]));
