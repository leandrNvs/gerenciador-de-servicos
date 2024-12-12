<?php

namespace Src\Database;

use Src\Foundation\Application;

use function Src\Helpers\modelToTable;

final class Schemas
{
    private $tableColumns = [];

    public function __construct(
        public Database $database,
        private $tableName,
        private $primaryKey,
    ) {}

    public static function new($model)
    {
        $tableInfo = modelToTable($model);

        return Application::getInstance()->resolve(
            static::class,
            [$tableInfo['tableName'], $tableInfo['primaryKey']]
        );
    }

    public function id()
    {
        $this->tableColumns[$this->primaryKey] = "INTEGER PRIMARY KEY AUTOINCREMENT";

        return $this;
    }

    public function varchar($col, $size = 255)
    {
        $this->tableColumns[$col] = "VARCHAR({$size}) NOT NULL";

        return $this;
    }

    public function text($col)
    {
        $this->tableColumns[$col] = "TEXT NOT NULL";

        return $this;
    }

    public function year($col)
    {
        $this->tableColumns[$col] = "YEAR NOT NULL";

        return $this;
    }

    public function date($col)
    {
        $this->tableColumns[$col] = "DATE NOT NULL";

        return $this;
    }

    public function bool($col)
    {
        $this->tableColumns[$col] = 'BOOL NOT NULL';

        return $this;
    }

    public function smallint($col)
    {
        $this->tableColumns[$col] = 'SMALLINT NOT NULL';

        return $this;
    }

    public function decimal($col, $total = 8, $places = 2)
    {
        $this->tableColumns[$col] = "DECIMAL({$total}, {$places}) NOT NULL";

        return $this;
    }


    public function foreignKeyFor($model)
    {
        $tableInfo = modelToTable($model);

        $foreignKey = $tableInfo['tableName'] . $tableInfo['primaryKey'];

        $this->tableColumns[$foreignKey] = "INTEGER";
        $this->tableColumns['FOREIGN KEY'] = "({$foreignKey}) REFERENCES {$tableInfo['tableName']}({$tableInfo['primaryKey']})";

        return $this;
    }

    public function optional()
    {
        $index = $this->getLastItem();

        $this->tableColumns[$index] = str_replace(' NOT NULL', '', $this->tableColumns[$index]);

        return $this;
    }
    
    public function default($value)
    {
        $index = $this->getLastItem();

        $this->tableColumns[$index] .= " DEFAULT {$value}";

        return $this;
    }

    public function get()
    {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS {{table}} (
                {{columns}}
            );
        SQL;

        $sql = str_replace('{{table}}', $this->tableName, $sql);

        $cols = array_map(function($col, $constraint) {
            return "{$col} {$constraint}";
        }, array_keys($this->tableColumns), $this->tableColumns);

        $sql = str_replace('{{columns}}', implode(",\n", $cols), $sql);

        return $sql;
    }

    private function getLastItem()
    {
        $key = array_keys($this->tableColumns);

        return end($key);
    }
}