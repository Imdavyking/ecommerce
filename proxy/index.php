<?php
if (!session_id()) session_start();

define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Content-Type:application/json');
  http_response_code(405);
  die(json_encode([
    'status' => 'error',
    'error' => 'access this page with method post'
  ]));
}

require_once "{$constantVar('root')}/includes/common_data.inc.php";
$data_obj = json_decode(file_get_contents('php://input'), true);
// $data_obj = [
//   'url' => 'https://nelka.house/proxy/r?name=david',
//   'method' => 'POST',
//   'body' => '{}',
//   'headers' => [
//     'content-type' => 'application/json',
//     'x-authorized' => 'Bearer 3018aldi3'
//   ]
// ];

if (!isset($data_obj['url'])  || !filter_var($data_obj['url'], FILTER_VALIDATE_URL)) die('url not given or invalid url');

if (strtolower(parse_url($data_obj['url'])['host']) === strtolower($_SERVER['SERVER_NAME'])) {
  header('Content-Type:application/json');
  http_response_code(400);
  die(json_encode([
    'status' => 'error',
    'error' => 'You can not run proxy on this server'
  ]));
}

$curl = curl_init($data_obj['url']);

$curlOptions = [
  CURLOPT_CUSTOMREQUEST => $data_obj['method'] ?? 'GET',
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_RETURNTRANSFER => true
];

if (isset($data_obj['method']) && $data_obj['method'] === 'DELETE') $curlOptions = $curlOptions + [
  CURLOPT_NOBODY => 1,
];

if (isset($data_obj['body'])) $curlOptions = $curlOptions + [
  CURLOPT_POSTFIELDS => $data_obj['body']
];

if (isset($data_obj['headers'])) {
  $headers = array_map(function ($key, $value) {
    return "$key:$value";
  }, array_keys($data_obj['headers']), array_values($data_obj['headers']));
  $curlOptions = $curlOptions + [
    CURLOPT_HTTPHEADER => $headers
  ];
}

if (debug)
  $curlOptions = $curlOptions + [
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST =>  false
  ];

curl_setopt_array($curl, $curlOptions);

$result = curl_exec($curl);
$error = curl_error($curl);

if ($error) {
  http_response_code(404);
  header('Content-Type:application/json');
  die(json_encode([
    'status' => 'error',
    'error' => 'Request Error: ' . $error
  ]));
} else die($result);
