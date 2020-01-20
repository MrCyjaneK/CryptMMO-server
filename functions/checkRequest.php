<?php
function checkRequest($request) {
    global $response;
    global $db;
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