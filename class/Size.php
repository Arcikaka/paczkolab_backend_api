<?php

class Size implements Action, JsonSerializable
{
    //prywatna wlasciwosc klasy, ktora przechowuje polaczenie
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
    private $size;
    /**
     * @var float
     */
    private $price;

    public function __construct()
    {
        $this->id = -1;
    }

    public function save()
    {
        self::$db->query("INSERT INTO Size SET size=:size, price=:price");
        self::$db->bind('size', $this->size);
        self::$db->bind('price', $this->price);
        self::$db->execute();

        $this->id = self::$db->lastInsertId();
    }

    public function update()
    {
        self::$db->query("UPDATE Size SET size=:size, price=:price WHERE id=:id");
        self::$db->bind('id',$this->id);
        self::$db->bind('size', $this->size);
        self::$db->bind('price', $this->price);
        self::$db->execute();
    }

    public function delete()
    {
        self::$db->query("DELETE FROM Size WHERE id = :id");
        self::$db->bind('id', $this->id);
        self::$db->execute();

    }

    public static function load($id = null)
    {
        if ($id == null) {
            return self::loadAll();
        }
        self::$db->query("SELECT * FROM Size WHERE id=:id");
        self::$db->bind('id', $id);
        $row = self::$db->single();


        $size = new Size();
        $size->id = $row['id'];
        $size->size = $row['size'];
        $size->price = $row['price'];
        return $size;
    }

    public static function loadAll()
    {
        self::$db->query("SELECT * FROM Size");
        $sizes = self::$db->resultSet();
        $result = [];
        foreach ($sizes as $size) {
            $new = new Size();
            $new->id = $size['id'];
            $new->size = $size['size'];
            $new->price = $size['price'];
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
            'size' => $this->size,
            'price' => $this->price
        ];
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}