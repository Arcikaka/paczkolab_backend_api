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
        return $this->createMySQLXMLDataSet(__DIR__ . '/../paczkolab_test.xml');
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

        $sizeTest = Size::load(3);

        $this->assertEquals($size->getSize(), $sizeTest->getSize());
        $this->assertEquals($size->getPrice(), $sizeTest->getPrice());

    }

    public function testLoadSize()
    {
        $size = Size::load(1);

        $this->assertEquals('S',$size->getSize());
        $this->assertEquals(8.00,$size->getPrice());

    }

    public function testUpdateSize()
    {
        $size = Size::load(3);
        $size->setSize('X');
        $size->setPrice(20);
        $size->update();


        $sizeTest = Size::load(3);

        $this->assertEquals($size->getPrice(),$sizeTest->getPrice());
        $this->assertEquals($size->getSize(),$sizeTest->getSize());

    }

    public function testDelete()
    {

        $size = Size::load(3);

        $size->delete();

        $sizeTest = Size::load(3);


        $this->assertNotSame($size,$sizeTest);
    }

    public function testLoadAllSize()
    {
        $sizes = Size::loadAll();
        $size = $sizes[0];
        $size2 = $sizes[1];

        $this->assertEquals('S',$size->getSize());
        $this->assertEquals(8.00,$size->getPrice());
        $this->assertEquals('M',$size2->getSize());
        $this->assertEquals(12.00,$size2->getPrice());


    }
}