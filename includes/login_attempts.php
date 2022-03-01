<?php
if (!session_id()) session_start();
if (!defined('root')) define('root', $_SERVER['DOCUMENT_ROOT']);
$constantVar = function ($name) {
  return constant($name);
};
require_once "{$constantVar('root')}/utils/db.php";


$stmtGetUser = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmtGetUser->execute([$data_obj->email]);
$user_id = $stmtGetUser->fetch(PDO::FETCH_ASSOC)['id'];

$stmtCountAttempts = $pdo->prepare('SELECT number_of_attempts FROM login_attempts  WHERE user_id = ?');
$stmtCountAttempts->execute([$user_id]);

$numberOfAttempts =  $stmtCountAttempts->fetch(PDO::FETCH_ASSOC)['number_of_attempts'];
$maxLoginAttempts = 5;


if ($numberOfAttempts === null) {
  $stmtInsertUserAttempt = $pdo->prepare('INSERT INTO login_attempts (user_id,number_of_attempts) VALUES (?,?)');
  $stmtInsertUserAttempt->execute([$user_id, 1]);
} else if ($numberOfAttempts < $maxLoginAttempts) {
  $stmtInsertUserAttempt = $pdo->prepare('UPDATE login_attempts SET number_of_attempts = ? WHERE user_id = ?');
  $stmtInsertUserAttempt->execute([(int)$numberOfAttempts + 1, $user_id]);
} else {
  $stmtGetTimeToRetry = $pdo->prepare("SELECT TIMESTAMPDIFF(MINUTE,last_attempt,now()) as minutesSpent FROM login_attempts WHERE user_id = ?");
  $stmtGetTimeToRetry->execute([$user_id]);
  $maxTimeToWait = 5;
  $getTimeToRetryResult = $maxTimeToWait - (int)$stmtGetTimeToRetry->fetch(PDO::FETCH_ASSOC)['minutesSpent'];
  if ($getTimeToRetryResult > $maxTimeToWait)
    die(json_encode([
      'status' => 'error',
      'error' => "There was an error, cleaning up former login attempts"
    ]));
  die(json_encode([
    'status' => 'error',
    'error' => "too many attempts, please try again in {$getTimeToRetryResult} minute(s)"
  ]));
}
