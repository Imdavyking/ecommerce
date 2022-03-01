<?php
header('Content-Type: application/json');
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
$stmt  = $pdo->prepare("SELECT products.id ,login_users.user_id FROM `login_users`,products WHERE login_users.user_id = ? && products.id = ?");
$stmt->execute([$data_obj->userId, $data_obj->itemId]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$stmtProductAddedAlready  = $pdo->prepare("SELECT user_id FROM cart WHERE user_id = ? && product_id = ?");
$stmtProductAddedAlready->execute([$data_obj->userId, $data_obj->itemId]);
if ($result && $stmtProductAddedAlready->rowCount() === 0) {
  $stmt  = $pdo->prepare("INSERT INTO cart (user_id,product_id) VALUES (?,?)");
  $stmt->execute([$data_obj->userId, $data_obj->itemId]);
  die(json_encode([
    'status' => 'success'
  ]));
} else if ($stmtProductAddedAlready->rowCount() !== 0) die(json_encode([
  'status' => 'error',
  'error' => 'Product Added Already'
]));
else die(json_encode([
  'status' => 'error',
  'error' => 'There was an error'
]));
