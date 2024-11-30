<?php

namespace Src\Database;

use App\Models\Model;

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
        if(!self::$instance):
            self::$instance = new \SQLite3($path, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        endif;

        return self::$instance;
    }
}