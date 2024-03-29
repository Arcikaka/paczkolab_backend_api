<?php

class Parcel implements Action, JsonSerializable
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
     * @var int
     */
    private $sizeId;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var int
     */
    private $addressId;


    public function save()
    {
        self::$db->query("INSERT INTO Parcel SET userId=:userId, sizeId=:sizeId, addressId=:addressId");
        self::$db->bind('userId', $this->userId);
        self::$db->bind('sizeId', $this->sizeId);
        self::$db->bind('addressId', $this->addressId);
        self::$db->execute();
        $this->id = self::$db->lastInsertId();
    }

    public function update()
    {
        self::$db->query("UPDATE Parcel SET userId=:userId, sizeId=:sizeId, addressId=:addressId WHERE id=:id");
        self::$db->bind('id', $this->id);
        self::$db->bind('userId', $this->userId);
        self::$db->bind('sizeId', $this->sizeId);
        self::$db->bind('addressId', $this->addressId);
        self::$db->execute();
    }


    public function delete()
    {
        self::$db->query("DELETE FROM Parcel WHERE id=:id");
        self::$db->bind('id', $this->id);
        self::$db->execute();
    }

    public static function load($id = null)
    {
        if ($id == null) {
            return self::loadAll();
        }
        self::$db->query("SELECT * FROM Parcel WHERE id=:id");
        self::$db->bind('id', $id);
        $row = self::$db->single();


        $parcel = new Parcel();
        $parcel->id = $row['id'];
        $parcel->userId = $row['userId'];
        $parcel->sizeId = $row['sizeId'];
        $parcel->addressId = $row['addressId'];
        return $parcel;
    }

    public static function loadAll()
    {
        self::$db->query("SELECT * FROM Parcel");
        $parcels = self::$db->resultSet();
        $result = [];
        foreach ($parcels as $parcel) {
            $new = new Parcel();
            $new->id = $parcel['id'];
            $new->userId = $parcel['userId'];
            $new->sizeId = $parcel['sizeId'];
            $new->addressId = $parcel['addressId'];
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
            'userId' => $this->userId,
            'sizeId' => $this->sizeId,
            'addressId' => $this->addressId
        ];
    }

    /**
     * @return int
     */
    public function getSizeId()
    {
        return $this->sizeId;
    }

    /**
     * @param int $sizeId
     */
    public function setSizeId(int $sizeId)
    {
        $this->sizeId = $sizeId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * @param int $addressId
     */
    public function setAddressId(int $addressId)
    {
        $this->addressId = $addressId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}