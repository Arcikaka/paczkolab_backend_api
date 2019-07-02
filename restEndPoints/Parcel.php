<?php


Parcel::setDb(new DBmysql());
User::setDb(new DBmysql());
Size::setDb(new DBmysql());


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response = Parcel::loadAll();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = User::load($_POST['user_id']);
    $credits = $user->getCredits();
    $size = Size::load($_POST['size_id']);
    $price = $size->getPrice();

    if($credits >= $price){
        $parcel = new Parcel();
        $parcel->setUserId($_POST['user_id']);
        $parcel->setAddressId($_POST['address_id']);
        $parcel->setSizeId($_POST['size_id']);
        $parcel->save();

        $newCredits = $credits - $price;
        $user->setCredits($newCredits);
        $user->update();
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    //to jest """$_POST['Patch']"""
    parse_str(file_get_contents("php://input"), $patchVars);

    $parcel = Parcel::load($patchVars['id']);
    $parcel->setUserId($patchVars['user_id']);
    $parcel->setAddressId($patchVars['address_id']);
    $parcel->setSizeId($patchVars['size_id']);
    $parcel->update();

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //to jest """$_POST['Delete']"""
    parse_str(file_get_contents("php://input"), $deleteVars);
    //pobieramy obiekt size o podanym id
    $user = Parcel::load($deleteVars['id']);
    $user->delete();
} else {
    $response = ['error' => 'Wrong request method'];
}
