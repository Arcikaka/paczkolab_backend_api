<?php
require_once __DIR__ . '/../config_test.php';

use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

class sizeTest extends TestCase
{
    use TestCaseTrait;
    /**
     * @var IDataSet
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
        return $this->createMySQLXMLDataSet(__DIR__ . '/../paczkolab_test_2.xml');
    }

    public function setUp()
    {
        parent::setUp();
        $this->dataSet = $this->getConnection()->createDataSet();
        Size::setDb(new DBmysql());
    }

    public function testSizeAdd()
    {
        $size = new Size();
        $size->setSize('MZ');
        $size->setPrice(24);
        $size->save();

        $sizeTest = Size::load($size->getId());

        $this->assertEquals($size->getSize(), $sizeTest->getSize());
        $this->assertEquals($size->getPrice(), $sizeTest->getPrice());

    }

    public function testDelete()
    {
        $this->markTestIncomplete();
        $size = new Size();
        $size->setSize('MX');
        $size->setPrice(26);
        $size->save();

        $sizeToDelete = Size::load($size->getId());

        $sizeToDelete->delete();

        $sizeTest = Size::load($size->getId());


        $this->assertNotEquals($size->getSize(), $sizeTest->getSize());
        $this->assertNotEquals($size->getPrice(), $sizeTest->getPrice());
    }

    public function testUpdateSize()
    {
        $this->markTestIncomplete();
        $id = $this->getConnection()->getConnection()->lastInsertId();
        $size = Size::load($id);
        $size->setSize('X');
        $size->setPrice(20);
        $size->update();


        $sizeTest = Size::load($id);

        $this->assertEquals($size->getPrice(),$sizeTest->getPrice());
        $this->assertEquals($size->getSize(),$sizeTest->getSize());

    }


    public function testLoadSize()
    {
        $size = Size::load(1);

        $this->assertEquals('S',$size->getSize());
        $this->assertEquals(8.00,$size->getPrice());

    }

    public function testLoadAllSize()
    {
        $sizes = Size::loadAll();
        $size = $sizes[0];

        $this->assertEquals('S',$size->getSize());
        $this->assertEquals(8.00,$size->getPrice());

    }
}