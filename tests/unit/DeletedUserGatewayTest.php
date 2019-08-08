<?php


class DeletedUserGateway extends \PHPUnit\Framework\TestCase
{
    private $gateway;
    private $pdo;
    private $id;

    public function setUp(): void
    {
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $this->gateway = new \Application\DeletedUserGateway($this->pdo);

        $this->insertTestUser();
    }

    public function testCountById()
    {
        $this->assertGreaterThan(0,         $this->gateway->countById());
    }

    public function testInsertByName()
    {
        $this->gateway->insertByName('foo');

        $sth = $this->pdo->query("select email from deleteduser where email='foo'", PDO::FETCH_OBJ);
        $this->assertEquals('foo', $sth->fetch()->email);
    }

    public function testFindAll()
    {
        list($results, $count) = $this->gateway->findAll();
        $this->assertIsArray($results);
        $this->assertGreaterThan(0, $count);
    }

    public function tearDown(): void
    {
        $this->pdo->query("delete from admin where id=" . $this->id);
    }

    private function insertTestUser()
    {
        $this->pdo->query("insert into deleteduser(email) values ('test@test.com')");
        $this->id = $this->pdo->lastInsertId();
    }
}