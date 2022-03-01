<?php

if (!session_id()) session_start();

if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/includes/common_data.inc.php";
outPutMinified('htmlStart');

if (!isset($_GET['reference'])) die("<script nonce='{$_SESSION['nonce']}'>history.go(-1)</script>");
$curl = curl_init();

$curlOptions = [
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/{$_GET['reference']}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer sk_test_f5f5ecdb7e064ad4e9dc119d70761bb0e2c17085",
    "Cache-Control: no-cache",
  ),

];

if (debug) {
  $curlOptions = $curlOptions + [
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST =>  false
  ];
}

curl_setopt_array($curl, $curlOptions);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err)  die("cURL Error #:{$err}");


$jsonResponse = json_decode($response);
if ($jsonResponse->data->status === 'success') {
  require_once "{$constantVar('root')}/utils/db.php";
  require_once "{$constantVar('root')}/includes/checkLogin.php";
  $stmtInsertPayment = $pdo->prepare('INSERT INTO payment_details (status,reference,fullname,email,amount) VALUES (?,?,?,?,?)');

  $stmtInsertPayment->execute([$jsonResponse->data->status, $jsonResponse->data->reference, "{$jsonResponse->data->customer->last_name}{$jsonResponse->data->customer->first_name}",   $jsonResponse->data->customer->email, $jsonResponse->data->amount / 100]);

  if (!$stmtInsertPayment) die('Sorry We couldn\'t not process the request');

  $stmt  = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
  $stmt->execute([$loginResult['user_id']]);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/style.min.css') ?>" />
  <title>Verify Payment | <?= $CONSTANT('COMPANY_DEFAULT_TITLE') ?></title>
</head>

<body>

  <?php if ($jsonResponse->data->status === 'success') : ?>
    <script nonce="<?= $_SESSION['nonce'] ?>">
      addEventListener('DOMContentLoaded', () => {
        swal({
          title: 'Payment successful',
          text: 'Your reference number is <?= $_GET['reference'] ?>, your product should have reach you in next 5 business days',
          icon: 'success'
        }).then(() => {
          window.location = '/';
        });
      });
    </script>
  <?php else : ?>
    <script nonce="<?= $_SESSION['nonce'] ?>">
      addEventListener('DOMContentLoaded', () => {
        swal({
          title: 'Payment failed',
          text: 'Please try and pay later',
          icon: 'error'
        }).then(() => {
          window.location = '/';
        });
      });
    </script>
  <?php endif; ?>
</body>

</html>