<?php
header('Content-Type:application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
  http_response_code(405);
  die(json_encode([
    'status' => 'error',
    'error' => 'access this page with method delete'
  ]));
}
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
if (!session_id()) session_start();
$data_obj = json_decode(file_get_contents("php://input"));
require_once "{$constantVar('root')}/api/csrf_check.php";
require_once "{$constantVar('root')}/utils/db.php";
$stmt  = $pdo->prepare("DELETE FROM cart WHERE user_id = ? && product_id = ?");
$stmt->execute([$data_obj->userId, $data_obj->itemId]);
die(json_encode([
  'status' => 'success'
]));
