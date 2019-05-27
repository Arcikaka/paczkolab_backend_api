<?php

User::setDb(new DBmysql());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response = User::loadAll();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $user->setName($_POST['name']);
    $user->setSurname($_POST['surname']);
    $user->setCredits($_POST['credits']);
    $user->setAddressId($_POST['address_id']);
    $user->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    //to jest """$_POST['Patch']"""
    parse_str(file_get_contents("php://input"), $patchVars);

    $user = User::load($patchVars['id']);
    $user->setName($_POST['name']);
    $user->setSurname($_POST['surname']);
    $user->setCredits($_POST['credits']);
    $user->setAddressId($_POST['address_id']);
    $user->update();

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //to jest """$_POST['Delete']"""
    parse_str(file_get_contents("php://input"), $deleteVars);
    //pobieramy obiekt size o podanym id
    $user = User::load($deleteVars['id']);
    $user->delete();
} else {
    $response = ['error' => 'Wrong request method'];
}