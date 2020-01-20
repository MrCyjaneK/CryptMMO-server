<?php
$host = $config->database->host;
$db   = $config->database->name;
$user = $config->database->user;
$pass = $config->database->pass;
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$db = new PDO($dsn, $user, $pass);