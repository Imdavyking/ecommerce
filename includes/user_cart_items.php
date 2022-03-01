<?php
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/includes/checkLogin.php";
require_once "{$constantVar('root')}/utils/db.php";
if ($loginResult) {
  $stmt  = $pdo->prepare("SELECT DISTINCT product_id,product_quantity FROM `cart` WHERE user_id = ?");
  $stmt->execute([$loginResult['user_id']]);
  $totalCartItem = $stmt->rowCount();
  $cartItemsDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $cartItemsIds = [];
  $cartItems = [];
  foreach ($cartItemsDetails as $key => $value) {
    $stmt  = $pdo->prepare("SELECT id,title,image,price,rating FROM `products` WHERE id = ?");
    $cartItemsIds[] = $value['product_id'];
    $stmt->execute([$value['product_id']]);
    $cartItems[] = $stmt->fetch(PDO::FETCH_ASSOC);
    $cartItems[$key]['product_quantity'] = $cartItemsDetails[$key]['product_quantity'];
  }
}
