<?php
require_once __DIR__ . '/../config_test.php';


use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

class userTest extends TestCase
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
        User::setDb(new DBmysql());
    }

    public function testSaveUser()
    {
        $user = new User();
        $user->setName('Andrzej');
        $user->setSurname('Sapkowski');
        $user->setCredits(20.00);
        $user->setAddressId(1);
        $user->save();

        $userTest = User::load(2);

        $this->assertEquals($user->getName(),$userTest->getName());
        $this->assertEquals($user->getSurname(),$userTest->getSurname());
        $this->assertEquals($user->getCredits(),$userTest->getCredits());
        $this->assertEquals($user->getAddressId(),$userTest->getAddressId());

    }

    public function testUpdateUser()
    {
        $user = User::load(2);
        $user->setCredits(22.00);
        $user->update();

        $userTest = User::load(2);

        $this->assertEquals($user->getCredits(),$userTest->getCredits());
    }

    public function testLoadUserById()
    {
        $user = User::load(1);

        $this->assertEquals('John',$user->getName());
        $this->assertEquals('Marston',$user->getSurname());
        $this->assertEquals(15.00,$user->getCredits());
        $this->assertEquals(2,$user->getAddressId());

    }

    public function testLoadAllUsers()
    {
        $users = User::loadAll();
        $user = $users[0];
        $user2 = $users[1];

        $this->assertEquals('John',$user->getName());
        $this->assertEquals('Marston',$user->getSurname());
        $this->assertEquals(15.00,$user->getCredits());
        $this->assertEquals(2,$user->getAddressId());
        $this->assertEquals('Andrzej',$user2->getName());
        $this->assertEquals('Sapkowski',$user2->getSurname());
        $this->assertEquals(22.00,$user2->getCredits());
        $this->assertEquals(1,$user2->getAddressId());
    }

    public function testDeleteUser()
    {
        $this->markTestIncomplete();
        $user = User::load(2);
        $user->delete();

        $userTest = User::load(2);

        $this->assertNotEquals($user->getName(),$userTest->getName());
        $this->assertNotEquals($user->getSurname(),$userTest->getSurname());
        $this->assertNotEquals($user->getCredits(),$userTest->getCredits());
        $this->assertNotEquals($user->getAddressId(),$userTest->getAddressId());

    }
}