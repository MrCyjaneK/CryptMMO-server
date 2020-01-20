<?php
$cookie = $request->auth->cookie;

$check = $db->prepare("SELECT * FROM `auth_accounts` WHERE `cookie`=:cookie");
$check->bindParam(":cookie",$cookie);
$check->execute();
$check = $check->fetchAll();
if ($check == []) {
    $response = [
        "loggedin" => false
    ];
} else {
    $response = [
        "loggedin" => true
    ];
    $user = $db->prepare("SELECT * FROM `users` WHERE `linked_hash`=:hash");
    $user->bindParam(":hash", $check[0]['linked_hash']);
    $user->execute();
    $user = $user->fetchAll()[0];
    foreach ($user as $key => $value) {
        $response[$key] = $value;
    }
}