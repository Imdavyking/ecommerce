<?php
header('Content-Type:application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  die(json_encode([
    'status' => 'error',
    'error' => 'access this page with method post'
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
if ($_SERVER['HTTP_X_ACTION'] === 'sign-up') {
  if (filter_var($data_obj->email, FILTER_VALIDATE_EMAIL) && strlen(trim($data_obj->password)) >= 6) {
    $random_token = sha1(random_bytes(256));
    $action = 'signup';
    ob_start();
    require_once "{$constantVar('root')}/partials/email_verify_template.php";
    $result = ob_get_clean();

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    if (mail($data_obj->email, 'Email Verification', $result, $headers)) {
      $stmt = $pdo->prepare("UPDATE users SET v_code = ? WHERE email = ?");
      $stmt->execute([$random_token, $data_obj->email]);
      $stmt  = $pdo->prepare("INSERT IGNORE INTO `users` (`userName`, `email`, `password`, `phone`,`v_code`) VALUES (?,?,?,?,?)");
      $stmt->execute([$data_obj->userName, $data_obj->email, password_hash($data_obj->password, PASSWORD_BCRYPT), $data_obj->phone, $random_token]);
      die(json_encode([
        'status' => 'success'
      ]));
    } else die(json_encode([
      'status' => 'error',
      'error' => 'Error while sending verification code to email'
    ]));
  } else die(json_encode([
    'status' => 'error',
    'error' => 'Form details not valid'
  ]));
} elseif ($_SERVER['HTTP_X_ACTION'] === 'login') {

  require_once "{$constantVar('root')}/includes/login_attempts.php";

  $stmt  = $pdo->prepare("SELECT id,email,password FROM users WHERE email = ?");
  $stmt->execute([$data_obj->email]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if (password_verify($data_obj->password, $result['password'])) {
    $stmt  = $pdo->prepare("DELETE FROM login_attempts WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $login_cookie = sha1(random_bytes(64));
    setcookie('userVerified', $login_cookie, time() + 60 * 60 * 24 * 365, "/", "", true, true);
    $stmt  = $pdo->prepare("INSERT IGNORE INTO `login_users` (`user_id`, `login_cookie`,`ip_address`,`user_agent`) VALUES (?,?,?,?)");
    $stmt->execute([$result['id'], $login_cookie, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']]);

    die(json_encode([
      'status' => 'success'
    ]));
  } else die(json_encode([
    'status' => 'error',
    'error' => 'incorrect password for email'
  ]));
}
