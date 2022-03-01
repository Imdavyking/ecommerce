<?php
header('Content-Type:application/json');
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/utils/db.php";
require_once "{$constantVar('root')}/includes/common_data.inc.php";
if (isset($_GET['limit'])) {
  $safeNumber = filter_var($_GET['limit'], FILTER_SANITIZE_NUMBER_INT);
  if ($safeNumber === '') header('Location: /api/products.php?limit=1');
  $stmt  = $pdo->prepare("SELECT * FROM products LIMIT $safeNumber");
} else $stmt  = $pdo->prepare("SELECT * FROM products");

$stmt->execute();
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($product as $key => $value)
  $product[$key]['image'] = $CACHE_BUSTER($product[$key]['image']);

$response = [
  "products" => $product
];
die(json_encode($response));
