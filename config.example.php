<?php
// Rename this file to 'config.php'
$config = [
    "database" => [
        "host" => "localhost",
        "name" => "databasename",
        "user" => "username",
        "pass" => "password"
    ]
];
// Make it std
$config = json_decode(json_encode($config));
