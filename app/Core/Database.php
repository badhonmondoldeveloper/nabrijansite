<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    /**
     * Get singleton PDO connection instance (lazy initialization).
     */
    public static function getInstance(): ?PDO {
        if (self::$instance === null) {
            $dbConfig = config('database');
            $dsn = sprintf(
                "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                $dbConfig['host'],
                $dbConfig['port'],
                $dbConfig['dbname'],
                $dbConfig['charset']
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $dbConfig['username'],
                    $dbConfig['password'],
                    $dbConfig['options']
                );
            } catch (PDOException $e) {
                error_log("Database Connection Warning: " . $e->getMessage());
                return null;
            }
        }
        return self::$instance;
    }
}
