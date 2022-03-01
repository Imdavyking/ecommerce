<?php
$pdo =  new PDO('mysql:host=localhost;dbname=naxtrust_real_estate;charset=utf8mb4', 'root', 'davyking');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
