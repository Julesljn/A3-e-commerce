<?php

use PHPUnit\Framework\TestCase;
use App\Database\Database;

class DatabaseTest extends TestCase
{
    private $pdoMock;
    private $stmtMock;
    private $database;

    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);

        Database::getConnection();
        $reflection = new ReflectionClass(Database::class);
        $property = $reflection->getProperty('connection');
        $property->setAccessible(true);
        $property->setValue(null, $this->pdoMock);

        $this->database = new Database();
    }

    public function testCreate(): void
    {
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('lastInsertId')->willReturn('1');

        $result = $this->database->create('users', ['name' => 'John']);

        $this->assertEquals(1, (int) $result);
    }

    public function testRead(): void
    {
        $this->pdoMock->method('query')->willReturn($this->stmtMock);
        $this->stmtMock->method('fetchAll')->willReturn([['id' => 1, 'name' => 'John']]);

        $result = $this->database->read('users', 'id = 1');

        $this->assertCount(1, $result);
        $this->assertEquals('John', $result[0]['name']);
    }

    public function testUpdate(): void
    {
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);

        $result = $this->database->update('users', ['name' => 'Jane'], ['id' => 1]);

        $this->assertTrue($result);
    }

    public function testDelete(): void
    {
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);

        $result = $this->database->delete('users', ['id' => 1]);

        $this->assertTrue($result);
    }
}
