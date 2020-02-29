<?php
$cookie = $request->auth->cookie;

$check = $db->prepare("SELECT * FROM `auth_accounts` WHERE `cookie`=:cookie");
$check->bindParam(":cookie",$cookie);
$check->execute();
$check = $check->fetchAll();
if ($check == []) {
    kill("Unauthorised");
}
// Fetch all items
$items = $db->prepare("SELECT * FROM `shop_items` WHERE `type`=:type");
$items->bindParam(":type", $request->params->category);
$items->execute();
$items = $items->fetchAll();

// User don't need to see items that he can't buy
//TODO: Display items that will be available on next level, with a lock or something on frontend.
foreach ($items as $key => $item) {
    if ($item["minlvl"] > $user->lvl) {
        //REMOVE_IN_PRODUCTION
        //unset($items[$key]);
    }
}

foreach ($items as $item) {
    $key = $item['ID'];
    $price = round($item["price"], 2) . " CRYPT";
    if ($price == 0) {
        $price = getString("SHOP->FREE");
    }
}

$response = ["items" => []];

foreach ($items as $item) {
    $response['items'][] = [
        "id" => $item['ID'],
        "name" => getString("SHOP->ITEM->NAME->".$item["ID"]),
        "attack" => round($item["attack"],2),
        "defense" => round($item["defense"],2),
        "weight" => round($item["weight"],2),
        "speed" => round($item["speed"],2),
        "price" => round($item["price"],2),
        "description" => getString("SHOP->ITEM->ABOUT->".$item['ID'])
    ];
}
