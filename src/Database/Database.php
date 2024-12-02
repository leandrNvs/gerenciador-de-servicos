<?php

namespace Src\Database;

use PDO;
use PDOException;

final class Database
{
    /**
     * Database connection;
     * 
     * @param Database
     */
    private static $instance;

    /**
     * Get the database connection
     * 
     * @return Database
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * Create a connection if not exists or just return it
     * 
     * @param string $path
     * @return Database;
     */
    public static function initialize($path)
    {
        try {
            $conn = new PDO('sqlite:' . $path);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$instance = $conn;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
}