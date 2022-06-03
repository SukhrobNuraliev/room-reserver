<?php

$driver = 'mysql';
$host = "localhost";
$database = "task";
$username = "root";
$password = "";

$pdo = new PDO("$driver:host=$host;dbname=$database", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

