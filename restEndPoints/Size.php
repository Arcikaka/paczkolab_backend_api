<?php
//ten plik odpowiada za obsługę różnego typu zapytań HTTP
//GET, POST etc dla klasy Size


//sprawdzamy jakim posobez zapytaniem weszliśmy na stronę
//plik ten powinien tworzyć zmienną $response, która będzie potem uzyta w router.php do wygenerowania
//jsona który zwrócony bedzie na frontend

//dodajemy połączenie z baza do klasy size
//nie mozemy przekazac bezposrednio polaczenie PDO
//poniewaz wymagana jest klasa implementujaca interfejs Database
SIZE::setDb(new DBmysql());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response = SIZE::loadAll(); //pobieramy wszystkie rozmiary
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $size = new Size();
    $size->setSize($_POST['size']);
    $size->setPrice($_POST['price']);
    $size->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    //to jest """$_POST['Patch']"""
    parse_str(file_get_contents("php://input"), $patchVars);

    //szukamy obiektu o danym id
    //aktualizujemy jego dane
    //zapisujemy
    $size = Size::load($patchVars['id']);
    $size->setPrice($patchVars['price']);
    $size->setSize($patchVars['size']);
    $size->update();



} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //to jest """$_POST['Delete']"""
    parse_str(file_get_contents("php://input"), $deleteVars);
    //pobieramy obiekt size o podanym id
    /** @var Size $size */
    $size = Size::load($deleteVars['id']);
    $size->delete();
} else {
    $response = ['error' => 'Wrong request method'];
}