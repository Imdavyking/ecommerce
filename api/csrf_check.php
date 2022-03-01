<?php
if (!session_id()) session_start();
if ($_SESSION['csrf_token'] !== $data_obj->csrfToken) {
  http_response_code(400);
  die(json_encode([
    'status' => 'error',
    'error' => 'csrf detected'
  ]));
}
