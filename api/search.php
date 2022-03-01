<?php
header('Content-Type:application/json');
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};


require_once "{$constantVar('root')}/utils/db.php";
require_once "{$constantVar('root')}/includes/common_data.inc.php";

if (!isset($_GET['query'])) {
  http_response_code(400);
  die(json_encode([
    'status' => 'error',
    'message' => 'please search a query'
  ]));
}


$pageNumber = filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT);

if ($pageNumber === '')
  die(header("Location: /api/search.php?query={$_GET['query']}&page=1"));

$itemPerPage = 5;
$offSet = ($pageNumber - 1) * $itemPerPage;
$stmt  = $pdo->prepare("SELECT * FROM products WHERE title LIKE '%{$_GET['query']}%' LIMIT $itemPerPage OFFSET $offSet");



$stmt->execute();
$stmtForTotalItem  = $pdo->prepare("SELECT COUNT(*) as SUM FROM products WHERE title LIKE '%{$_GET['query']}%'");

$stmtForTotalItem->execute();

$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($product as $key => $value)
  $product[$key]['image'] = $CACHE_BUSTER($product[$key]['image']);

die(json_encode([
  'total_pages' => ceil($stmtForTotalItem->fetch(PDO::FETCH_ASSOC)['SUM'] / $itemPerPage),
  'status' => 'success',
  'products' => $product,
  'current_page' => (int)$pageNumber
]));
