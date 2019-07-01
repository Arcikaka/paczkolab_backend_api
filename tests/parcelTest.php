<?php
require_once __DIR__ . '/../config_test.php';


use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

class parcelTest extends TestCase
{
    use TestCaseTrait;
    /**
     * @var IDataSet;
     */
    private $dataSet;

    /**
     * Returns the test database connection.
     *
     * @return Connection
     */
    protected function getConnection()
    {
        $pdo = new PDO($GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWORD']);
        return $this->createDefaultDBConnection($pdo, $GLOBALS['DB_NAME']);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/../paczkolab_test.xml');
    }

    public function setUp()
    {
        parent::setUp();
        $this->dataSet = $this->getConnection()->createDataSet();
        Parcel::setDb(new DBmysql());
    }

    public function testSaveParcel()
    {
        $parcel = new Parcel();
        $parcel->setSizeId(1);
        $parcel->setUserId(1);
        $parcel->setAddressId(1);
        $parcel->save();

        $parcelTest = Parcel::load(2);

        $this->assertEquals($parcel->getSizeId(),$parcelTest->getSizeId());
        $this->assertEquals($parcel->getUserId(),$parcelTest->getUserId());
        $this->assertEquals($parcel->getAddressId(),$parcelTest->getAddressId());
    }

    public function testLoadParcelById()
    {
        $parcel = Parcel::load(2);
        $this->assertEquals(1,$parcel->getSizeId());
        $this->assertEquals(1,$parcel->getUserId());
        $this->assertEquals(1,$parcel->getAddressId());

    }

    public function testLoadAllParcels()
    {
        $parcels = Parcel::loadAll();
        $parcel = $parcels[0];
        $parcel2 = $parcels[1];

        $this->assertEquals(2,$parcel->getSizeId());
        $this->assertEquals(1,$parcel->getUserId());
        $this->assertEquals(1,$parcel->getAddressId());
        $this->assertEquals(1,$parcel2->getSizeId());
        $this->assertEquals(1,$parcel2->getUserId());
        $this->assertEquals(1,$parcel2->getAddressId());

    }

    public function testUpdateParcel()
    {
        $parcel = Parcel::load(2);
        $parcel->setSizeId(2);
        $parcel->update();

        $parcelTest = Parcel::load(2);

        $this->assertEquals($parcel->getSizeId(),$parcelTest->getSizeId());

    }

    public function testDeleteParcel()
    {
        $parcel = Parcel::load(2);
        $parcel->delete();

        $parcelTest = Parcel::load(2);

        $this->assertNotEquals($parcel->getSizeId(),$parcelTest->getSizeId());
        $this->assertNotEquals($parcel->getUserId(),$parcelTest->getUserId());
        $this->assertNotEquals($parcel->getAddressId(),$parcelTest->getAddressId());
    }

}