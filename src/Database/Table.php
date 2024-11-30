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
        $tableName = explode('\\', $reflection->getName());

        return new static(strtolower(end($tableName)), $primaryKey);
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
        $index = count($this->tableColumns) - 1;

        $this->tableColumns[$index] = str_replace('NOT NULL', '', $index);

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

}