<?php
header('Content-Type:application/json');
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/includes/user_cart_items.php";
require_once "{$constantVar('root')}/includes/common_data.inc.php";
foreach ($cartItems as $key => $value)
  $cartItems[$key]['image'] = $CACHE_BUSTER($cartItems[$key]['image']);
die(json_encode($cartItems));
