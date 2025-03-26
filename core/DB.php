<?php

class DB
{
    private static $pdo;

    private static function connect()
    {
        if (self::$pdo === null) {
            $dbPath = __DIR__ . '/../database.db'; 
            self::$pdo = new PDO('sqlite:' . $dbPath);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }

    public static function query($sql, $params = [])
    {
        $stmt = self::connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
