<?php

namespace Src\Database;

use App\Models\Model;
use ReflectionClass;

final class Table
{
    private $tableColumns = [];

    private $table;

    private $primaryKey;

    public function __construct($tableName, $primaryKey) {
        $this->table = $tableName;
        $this->primaryKey = $primaryKey;
    }

    public static function schema($model)
    {
        $reflection = new ReflectionClass($model);

        $primaryKey = $reflection->getProperty('primaryKey')->getDefaultValue();
        $tableName = $reflection->getProperty('table')->getDefaultValue() ?? explode('\\', $reflection->getName());

        $table = is_array($tableName)? end($tableName) : $tableName;

        return new static(strtolower($table), $primaryKey);
    }

    public function identifier($col = null)
    {
        $this->tableColumns[$col ?? $this->primaryKey] = "INTEGER UNSIGNED PRIMARY KEY AUTOINCREMENT";

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

    public function decimal($col, $total = 8, $places = 2)
    {
        $this->tableColumns[$col] = "DECIMAL({$total}, {$places}) NOT NULL";

        return $this;
    }


    public function foreignKeyFor($model)
    {
        $reflection = new ReflectionClass($model);

        $primaryKey = $reflection->getProperty('primaryKey')->getDefaultValue();

        $tableName = explode('\\', $reflection->getName());
        $tableName = strtolower(end($tableName));

        $fkCol = $tableName . $primaryKey;

        $this->tableColumns[$fkCol] = "INTEGER UNSIGNED";
        $this->tableColumns['FOREIGN KEY'] = "{$fkCol} REFERENCES {$tableName}({$primaryKey})";

        return $this;
    }

    public function optional()
    {
        $index = $this->getLastItem();

        $this->tableColumns[$index] = str_replace(' NOT NULL', '', $this->tableColumns[$index]);

        return $this;
    }

    public function get()
    {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS {{table}} (
                {{columns}}
            );
        SQL;

        $sql = str_replace('{{table}}', $this->table, $sql);

        $cols = array_map(function($col, $constraint) {
            return "{$col} {$constraint}";
        }, array_keys($this->tableColumns), $this->tableColumns);

        $sql = str_replace('{{columns}}', implode(",\n", $cols), $sql);

        echo '<pre>';
        echo $sql;
        echo '</pre>';

        return null;
    }

    private function getLastItem()
    {
        $key = array_keys($this->tableColumns);

        return end($key);
    }


}