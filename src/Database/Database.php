<?php

namespace Src\Database;

use SQLite3;

class Database
{
    private static $connection;

    public static function initialize($path)
    {
        if(!file_exists($path)) {
            mkdir($path);
        }

        if(!self::$connection) {
            self::$connection = new SQLite3($path . 'gerenciamento.db', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        }
    }

    public static function getConnection()
    {
        return self::$connection;
    }

    public static function createTableIf($dbname, $sql, $primaryKey = 'id')
    {
        $id = [$primaryKey => 'INTEGER PRIMARY KEY AUTOINCREMENT'];
        $sql = array_merge($id, $sql);

        $utility = new class($dbname, $sql, $primaryKey) {

            private $query;

            private $primaryKey;

            private $dbname;

            public function __construct($dbname, $query, $primaryKey)
            {
                $this->query = $query;
                $this->primaryKey = $primaryKey;
                $this->dbname = $dbname;
            }

            public function foreignKey($object) {
                $fkField = $object->dbname . $object->primaryKey;

                $this->query[$fkField] = 'MEDIUMINT UNSIGNED';
                $this->query['FOREIGN KEY'] = "({$fkField}) REFERENCES {$object->dbname}($object->primaryKey)";

                return $this;
            }

            public function query() {
                $query = "CREATE TABLE IF NOT EXISTS {$this->dbname} (\n{{fields}});";

                $this->query = array_map(function($col, $constraint) {
                    return "{$col} {$constraint}";
                }, array_keys($this->query), $this->query);

                return str_replace('{{fields}}', implode(",\n",$this->query), $query);
            }
        };

        return $utility;
    }
}
