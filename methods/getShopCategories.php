<?php
$cookie = $request->auth->cookie;

$check = $db->prepare("SELECT * FROM `auth_accounts` WHERE `cookie`=:cookie");
$check->bindParam(":cookie",$cookie);
$check->execute();
$check = $check->fetchAll();
if ($check == []) {
    kill("Unauthorised");
} else {
    $categories = $db->prepare("SELECT `ID`,`type` FROM `item_cat_info`");
    $categories->execute();
    $categories = $categories->fetchAll();
    $response = [];
    $response['categories'] = [];
    foreach ($categories as $category) {
        $response['categories'][] = [
            "id" => $category['ID'],
            "name" => getString($category['type']), // CATEGORY->TYPE->SWORD...
            "description" => "#TODO"
        ];
    }
}
