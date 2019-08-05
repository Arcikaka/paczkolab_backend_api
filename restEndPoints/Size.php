<?php
// this file is responsible to manage request method


//check request method
//$response is used to generate json for frontEnd

//adds connection with dataBase, because we cannot connect direct with PDO.
//We need to use class who implements interface Database

SIZE::setDb(new DBmysql());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response = SIZE::loadAll(); //load all Sizes
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $size = new Size();
    $size->setSize($_POST['size']);
    $size->setPrice($_POST['price']);
    $size->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    //this is """$_POST['Patch']"""
    parse_str(file_get_contents("php://input"), $patchVars);

    //we search for the object, update it and save
    $size = Size::load($patchVars['id']);
    $size->setPrice($patchVars['price']);
    $size->setSize($patchVars['size']);
    $size->update();


} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //this is """$_POST['Delete']"""
    parse_str(file_get_contents("php://input"), $deleteVars);
    //load Size by Id
    /** @var Size $size */
    $size = Size::load($deleteVars['id']);
    $size->delete();
} else {
    $response = ['error' => 'Wrong request method'];
}