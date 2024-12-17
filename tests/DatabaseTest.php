<?php

use PHPUnit\Framework\TestCase;
use App\Database\Database;

class DatabaseTest extends TestCase
{
    private $pdoMock;
    private $database;

    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(PDO::class);

        $reflection = new ReflectionClass(Database::class);
        $property = $reflection->getProperty('connection');
        $property->setAccessible(true);
        $property->setValue(null, $this->pdoMock);

        $this->database = new Database();
    }

    public function testCreate(): void
    {
        $stmtMock = $this->createMock(PDOStatement::class);

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock
            ->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $this->pdoMock
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn('1');

        $result = $this->database->create('users', ['name' => 'John', 'age' => 30]);

        $this->assertEquals(1, $result);
    }

    public function testRead(): void
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn([['id' => 1, 'name' => 'John']]);

        $this->pdoMock
            ->expects($this->once())
            ->method('query')
            ->willReturn($stmtMock);

        $result = $this->database->read('users', 'id = 1');

        $this->assertCount(1, $result);
        $this->assertEquals('John', $result[0]['name']);
    }

    public function testUpdate(): void
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock
            ->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $result = $this->database->update('users', ['name' => 'Jane'], ['id' => 1]);

        $this->assertTrue($result);
    }

    public function testDelete(): void
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock
            ->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $result = $this->database->delete('users', ['id' => 1]);

        $this->assertTrue($result);
    }
}
