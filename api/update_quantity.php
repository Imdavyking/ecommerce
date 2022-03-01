<?php
header('Content-Type:application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
  http_response_code(405);
  die(json_encode([
    'status' => 'error',
    'error' => 'access this page with method put'
  ]));
}
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
if (!session_id()) session_start();
$data_obj = json_decode(file_get_contents("php://input"));

if ($data_obj->quantity < 1) die(json_encode([
  'status' => 'error',
  'error' => 'quantity cannot be less than zero(0)'
]));

if ($data_obj->quantity > 10) die(json_encode([
  'status' => 'error',
  'error' => 'quantity cannot greater than 10'
]));

require_once "{$constantVar('root')}/api/csrf_check.php";
require_once "{$constantVar('root')}/utils/db.php";
$stmt  = $pdo->prepare("UPDATE cart SET product_quantity = ? WHERE user_id = ? && product_id = ?");
$stmt->execute([$data_obj->quantity, $data_obj->userId, $data_obj->itemId]);
die(json_encode([
  'status' => 'success'
]));
