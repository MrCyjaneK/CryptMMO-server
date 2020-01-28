<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
include getcwd() . '/config.php';
include getcwd() . '/db.php';
include getcwd() . '/functions/kill.php';
include getcwd() . '/functions/generateRandomString.php';
include getcwd() . '/functions/checkRequest.php';
include getcwd() . '/functions/getString.php';
$request = json_decode((file_get_contents("php://input")));
$response = [];
checkRequest($request);

$res = [
    "request" => json_decode(file_get_contents("php://input")),
    "ok" => true,
    "urid" => $request->urid,
    "response" => $response,
    "error" => null
];
echo json_encode($res,JSON_PRETTY_PRINT);