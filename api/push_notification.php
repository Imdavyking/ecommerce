<?php
if (!session_id()) session_start();
header('Content-Type:application/json');
$root = $_SERVER['DOCUMENT_ROOT'];
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  die(json_encode([
    'status' => 'error',
    'error' => 'access this page with method post'
  ]));
}
require_once("$root/vendor/autoload.php");
require_once("$root/includes/common_data.inc.php");

$data_obj = json_decode(file_get_contents("php://input"));
require_once "$root/api/csrf_check.php";
require_once "$root/utils/db.php";

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

use function GuzzleHttp\json_encode;



if (isset($_GET['subscribe'])) {
  $stmt  = $pdo->prepare('SELECT endpoint FROM web_push WHERE endpoint = ?');
  $stmt->execute([$data_obj->endpoint]);

  if ($stmt->rowCount() === 0) {
    $stmt  = $pdo->prepare('INSERT INTO web_push(endpoint,expirationTime,key_p256dh,key_auth) VALUES (?,?,?,?)');
    $stmt->execute([
      $data_obj->endpoint,
      $data_obj->expirationTime ?? null,
      $data_obj->keys->p256dh,
      $data_obj->keys->auth
    ]);

    http_response_code(201);

    die(json_encode([
      'success' => true
    ]));
  }
  die(json_encode([
    'success' => false
  ]));
}
if (isset($_GET['sendPush'])) {
  $condition = 1;

  $stmt  = $pdo->prepare('SELECT endpoint,expirationTime,key_p256dh,key_auth FROM web_push WHERE ?');
  $stmt->execute([$condition]);
  $subscriptions = [];

  if ($stmt->rowCount() !== 0) {

    $subscriptions_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($subscriptions_users as $key => $value)
      $subscriptions[] =  [
        'endpoint' => $subscriptions_users[$key]['endpoint'],
        'expirationTime' => $subscriptions_users[$key]['expirationTime'],
        'keys' => [
          'p256dh' => $subscriptions_users[$key]['key_p256dh'],
          'auth' => $subscriptions_users[$key]['key_auth'],
        ],
        'contentEncoding' => 'aesgcm',
      ];

    // Example payload
    //  $payload = [
    //     'title' => 'Pastor Paul comes to Nigeria',
    //     'options' => [
    //         'body' => 'The anointed man of God,Pastor Paul reached Nigeria about 3am today and he is going to hold crusades',
    //         'icon' => '/favicon.ico',
    //         'image' => '/img/colorlayout.jpg',
    //         'tag' => 'msg',
    //         'data' => [
    //             'primaryKey' => 1,
    //             'url' => 'https://nelka.house',
    //         ],
    //         'vibrate' => [100, 50, 100],
    //         'actions' => [
    //             [
    //                 'action' => 'explore',
    //                 'title' => 'Tell me more',
    //                 'icon' => '/img/explore.png',
    //             ],
    //             [
    //                 'action' => 'close',
    //                 'title' => 'No thank you',
    //                 'icon' => '/img/close.png',
    //             ],
    //         ],
    //     ],
    // ];

    $payload = json_decode(file_get_contents('php://input'), true);
    // here I'll get the subscription endpoint in the POST parameters
    // but in reality, you'll get this information in your database
    // because you already stored it (cf. push_subscription.php)

    $pushNotificationResults = [];
    foreach ($subscriptions as  $subscribed) {
      $subscription = Subscription::create($subscribed);

      $webPush = new WebPush([
        'VAPID' => [
          'subject' => $_SERVER['SERVER_NAME'],
          'publicKey' => $userConfig['vapid_PublicKey'], // don't forget that your public key also lives in app.js
          'privateKey' =>  $userConfig['vapid_PrivateKey'], // in the real world, this would be in a secret file
        ],
      ]);

      $report = $webPush->sendOneNotification(
        $subscription,
        json_encode($payload)
      );

      // handle eventual errors here, and remove the subscription from your server if it is expired
      $endpoint = $report->getRequest()->getUri()->__toString();

      if ($report->isSuccess())
        $pushNotificationResults[] = [
          'endpoint' => $endpoint,
          'success' => true
        ];
      else
        $pushNotificationResults[] = [
          'endpoint' => $endpoint,
          'success' => false,
          'reason' => $report->getReason()
        ];
    }
    $pushNotificationResults['success'] = true;
    die(json_encode($pushNotificationResults));
  } else die(json_encode([
    'endpoint' => [],
    'success' => false,
    'reason' => 'No users available'
  ]));
}
