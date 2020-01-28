<?php
function checkRequest($request) {
    global $response;
    global $db;
    include getcwd() . '/functions/getUser.php'; // Actually, not a function. this sets the '$user' varible
    if ($request == null) {
        kill("Empty or invalid request provided");
    }
    $method = preg_replace("/[^a-zA-Z0-9]+/", "", $request->method);
    if (file_exists(getcwd()."/methods/".$method.".php")) {
        include getcwd()."/methods/".$method.".php";
    } else {
        kill("Unknown method: '$method'");
    }
}