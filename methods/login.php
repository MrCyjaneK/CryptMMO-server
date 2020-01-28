<?php
// Allow user to login/register.
$url = "https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=".$request->params;
$isvalid = json_decode(file_get_contents($url));
if (!isset($isvalid->email)) {
    kill("Problems with login, try again.");
}

// Create user account, and/or login.
$email = $isvalid->email;
// Check if exists
$check = $db->prepare("SELECT * FROM `auth_accounts` WHERE `email`=:email");
$check->bindParam(":email", $email);
$check->execute();
$check = $check->fetchAll();
$cookie = generateRandomString(256);
//throw new Exception (print_r($check,1).PHP_EOL.print_r($email,1));
if ($check == []) {
    // Create account
    $hash = generateRandomString(2048);
    $username = explode('@',$email)[0]."_".generateRandomString(5);
    $create_account = $db->prepare("INSERT INTO `users`(`username`,`linked_hash`) VALUES (:username, :hash)");
    $create_account->bindParam(":username",$username);
    $create_account->bindParam(":hash",$hash);
    $create_account->execute();
    // Create auth profile.
    $create_auth = $db->prepare("INSERT INTO `auth_accounts`(`email`, `linked_hash`) VALUES (:email,:hash)");
    $create_auth->bindParam(":email",$email);
    $create_auth->bindParam(":hash",$hash);
    $create_auth->execute();
} else {
    $hash = $check[0]['linked_hash'];
}

$cookie = generateRandomString(32);
$savecookie = $db->prepare("UPDATE `auth_accounts` SET `cookie`=:cookie WHERE `email`=:email");
$savecookie->bindParam(":cookie",$cookie);
$savecookie->bindParam(":email",$email);
$savecookie->execute();
$response = [
    "cookie" => $cookie
];