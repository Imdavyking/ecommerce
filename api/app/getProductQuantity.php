<?php
header('Content-Type:application/json');
if (!session_id()) session_start();
$constantVar = function ($name) {
  return constant($name);
};

if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);

require_once "{$constantVar('root')}/utils/db.php";

$stmtUserQuantityOfProduct = $pdo->prepare("SELECT product_quantity FROM cart WHERE user_id = ? && product_id = ?");
$jsonRequestBody = json_decode(file_get_contents('php://input'));
$stmtUserQuantityOfProduct->execute([$jsonRequestBody->userId, $jsonRequestBody->itemId]);
die(json_encode([
  'quantity' => $stmtUserQuantityOfProduct->fetch(PDO::FETCH_ASSOC)['product_quantity'] ?? 1
]));
