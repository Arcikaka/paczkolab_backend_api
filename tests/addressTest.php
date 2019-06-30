<?php
require_once __DIR__ . '/../config_test.php';

use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

class addressTest extends TestCase
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
        Address::setDb(new DBmysql());
    }

    public function testSaveAddress()
    {
        $address = new Address();
        $address->setCity('Warsaw');
        $address->setCode('63-100');
        $address->setStreet('Sapkowskiego');
        $address->setFlat('24');
        $address->save();

        $id = $address->getId();

        $addressTest = Address::load($id);

        $this->assertEquals($address->getCity(),$addressTest->getCity());
        $this->assertEquals($address->getCode(),$addressTest->getCode());
        $this->assertEquals($address->getStreet(),$addressTest->getStreet());
        $this->assertEquals($address->getFlat(),$addressTest->getFlat());

    }
    public function testUpdateAddress()
    {
        $address = Address::load(2);
        $address->setCity('Novigrad');
        $address->update();

        $addressTest = Address::load(2);

        $this->assertEquals($address->getCity(),$addressTest->getCity());

    }
    public function testDeleteAddress()
    {
        $address = new Address();
        $address->setCity('Warsaw');
        $address->setCode('63-100');
        $address->setStreet('Sapkowskiego');
        $address->setFlat('24');
        $address->save();

        $id = $address->getId();
        $address->delete();

        $addressTest = Address::load($id);

        $this->assertNotEquals($address->getCity(),$addressTest->getCity());
        $this->assertNotEquals($address->getCode(),$addressTest->getCode());
        $this->assertNotEquals($address->getStreet(),$addressTest->getStreet());
        $this->assertNotEquals($address->getFlat(),$addressTest->getFlat());
    }
    public function testLoadAddressById()
    {
        $address = Address::load(1);

        $this->assertEquals('Poznan',$address->getCity());
        $this->assertEquals('62-100',$address->getCode());
        $this->assertEquals('Doznan',$address->getStreet());
        $this->assertEquals('201',$address->getFlat());
    }
    public function testLoadAllAddressTest()
    {
        $addresses = Address::loadAll();
        $address = $addresses[0];
        $address2 = $addresses[1];

        $this->assertEquals('Poznan',$address->getCity());
        $this->assertEquals('62-100',$address->getCode());
        $this->assertEquals('Doznan',$address->getStreet());
        $this->assertEquals('201',$address->getFlat());
        $this->assertEquals('Novigrad',$address2->getCity());
        $this->assertEquals('63-100',$address2->getCode());
        $this->assertEquals('Sapkowskiego',$address2->getStreet());
        $this->assertEquals('24',$address2->getFlat());
    }

}