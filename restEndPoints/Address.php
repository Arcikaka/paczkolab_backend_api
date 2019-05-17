<?php

Address::setDb(new DBmysql());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response = Address::loadAll(); //pobieramy wszystkie rozmiary
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = new Address();
    $address->setCity($_POST['city']);
    $address->setCode($_POST['code']);
    $address->setStreet($_POST['street']);
    $address->setFlat($_POST['flat']);

    $address->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    //to jest """$_POST['Patch']"""
    parse_str(file_get_contents("php://input"), $patchVars);

    //szukamy obiektu o danym id
    //aktualizujemy jego dane
    //zapisujemy
    $address = Address::load($patchVars['id']);
    $address->setCity($_POST['city']);
    $address->setCode($_POST['code']);
    $address->setStreet($_POST['street']);
    $address->setFlat($_POST['flat']);
    $address->update();

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //to jest """$_POST['Delete']"""
    parse_str(file_get_contents("php://input"), $deleteVars);
    //pobieramy obiekt size o podanym id
    /** @var Size $size */
    $address = Address::load($deleteVars['id']);
    $address->delete();
} else {
    $response = ['error' => 'Wrong request method'];
}