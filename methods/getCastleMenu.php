<?php
/*
let request = {
    "urid": "UniqueRequestId",
    "method": "getCastleMenu",
    "params": null
}
*/
$cookie = $request->auth->cookie;

$check = $db->prepare("SELECT * FROM `auth_accounts` WHERE `cookie`=:cookie");
$check->bindParam(":cookie",$cookie);
$check->execute();
$check = $check->fetchAll();
if ($check == []) {
    kill("Unauthorised");
} else {
    $response = [];
    $response['menu'] = [
            [
                [
                    "text" => "AliÐoge",
                    "icon" => "LocalMall",
                    "key" => "castleShop",
                    "action" => "render:Shop",
                    "size" => "50%"
                ],
                [
                    "text" => "ReÐolud",
                    "icon" => "AccountBalance",
                    "key" => "castleBank",
                    "action" => "render:Bank",
                    "size" => "50%"
                ],
            ],
            [
                [
                    "text" => "Battle",
                    "icon" => "Adb",
                    "key" => "castleBattle",
                    "action" => "render:Battle",
                    "size" => "50%"
                ],
                [
                    "text" => "Tavern",
                    "icon" => "OutdoorGrill",
                    "key" => "castleTavern",
                    "action" => "render:Tavern",
                    "size" => "50%"
                ],
            ],
            [
                [
                    "text" => "Walk",
                    "icon" => "Walk",
                    "key" => "castleWalk",
                    "action" => "render:Walk",
                    "size" => "100%"
                ],
            ]
        ];
}
