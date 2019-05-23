<?php

class User implements Action, JsonSerializable
{
    /**
     * @var Database
     */
    private static $db;
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $surname;
    /**
     * @var int
     */
    private $credits;
    /**
     * @var int
     */
    private $addressId;

    public function save()
    {
        self::$db->query("INSERT INTO User SET name=:name, surname=:surname, credits=:credits, addressId=:addressId");
        self::$db->bind('name', $this->name);
        self::$db->bind('surname', $this->surname);
        self::$db->bind('credits', $this->credits);
        self::$db->bind('addressId', $this->addressId);
        self::$db->execute();
    }

    public function update()
    {
        self::$db->query("UPDATE User SET name=:name, surname=:surname, credits=:credits, addressId=:addressId WHERE  id=:id");
        self::$db->bind('id', $this->id);
        self::$db->bind('name', $this->name);
        self::$db->bind('surname', $this->surname);
        self::$db->bind('credits', $this->credits);
        self::$db->bind('addressId', $this->addressId);
        self::$db->execute();
    }

    public function delete()
    {
        self::$db->query("DELETE FROM User WHERE id = :id");
        self::$db->bind('id', $this->id);
        self::$db->execute();
    }

    public static function load($id = null)
    {
        if ($id == null) {
            return self::loadAll();
        }
        self::$db->query("SELECT * FROM User WHERE id=:id");
        self::$db->bind('id', $id);
        $row = self::$db->single();


        $user = new User();
        $user->id = $row['id'];
        $user->name = $row['name'];
        $user->surname = $row['surname'];
        $user->credits = $row['credits'];
        $user->addressId = $row['addressId'];
        return $user;
    }

    public static function loadAll()
    {
        //wywolujemy metody z klasy DBmysql poniewaz to ona jest nakladka na PDO i ma odpowiednia implementacje metod PDO
        self::$db->query("SELECT * FROM User JOIN Address A on User.addressId = A.id");
        $users = self::$db->resultSet();//to jest tablica z wierszami Size z bazy
        $result = [];
        foreach ($users as $user) {
            $new = new User();
            $new->id = $user['id'];
            $new->name = $user['name'];
            $new->surname = $user['surname'];
            $new->credits = $user['credits'];
            $new->addressId = $user['addressId'];
            $result[] = $new;
        }
        return $result;
    }

    public static function setDb(Database $db)
    {
        self::$db = $db;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'credits' => $this->credits,
            'addressId' => $this->addressId
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return int
     */
    public function getCredits(): int
    {
        return $this->credits;
    }

    /**
     * @param int $credits
     */
    public function setCredits(int $credits): void
    {
        $this->credits = $credits;
    }

    /**
     * @return int
     */
    public function getAddressId(): int
    {
        return $this->addressId;
    }

    /**
     * @param int $addressId
     */
    public function setAddressId(int $addressId): void
    {
        $this->addressId = $addressId;
    }
}