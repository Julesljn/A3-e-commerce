<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(dsn: 'mysql:host=localhost;dbname=ecom;charset=utf8', username: 'root', password: 'root');
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
    public function read($table, $conditions = '')
    {
        $request = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $request .= " WHERE $conditions";
        }
        $stmt = $this->getConnection()->query($request);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
