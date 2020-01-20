<?php
function kill($message, $urid = "N/A") {
    $res = [
        "request" => file_get_contents("php://input"),
        "ok" => false,
        "urid" => $urid,
        "response" => null,
        "error" => [
            "message" => $message
        ]
    ];
    echo json_encode($res,JSON_PRETTY_PRINT);
    die();
}