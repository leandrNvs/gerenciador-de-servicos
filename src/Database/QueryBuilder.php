<?php

namespace Src\Database;

use PDO;

final class QueryBuilder
{
    private $tableName;

    private $query;

    private $whereData = [];

    public function __construct(private Database $database) {}

    public function __call($name, $arguments)
    {
        switch(strtolower($name)) {
            case 'insert':
                    $this->query = "INSERT INTO {$this->tableName} ({{columns}}) VALUES ({{values}})";
                break;
            case 'delete':
                    $this->query = "DELETE FROM {$this->tableName}";
                break;
            case 'update':
                    $this->query = "UPDATE {$this->tableName} SET {{columns}}";
                break;
            case 'select':
                    $columns = empty($arguments)? '*' : $arguments[0];

                    $this->query = "SELECT {$columns} FROM {$this->tableName}";
                break;
            case 'where':

                    $this->whereData[$arguments[0]] = count($arguments) === 2? $arguments[1] : $arguments[2];

                    $this->query .= " WHERE {$arguments[0]} " . (count($arguments) === 2? "=" : $arguments[1]) . " :{$arguments[0]}";

                    break;
            case 'limit':
                    $this->query .= " LIMIT {$arguments[0]}";
                break;
            case 'offset':
                    $this->query .= " OFFSET {$arguments[0]}";
                break;
        }

        return $this;
    }

    public function table($table)
    {
        $this->tableName = $table;

        return $this;
    }

    public function execute($data = [])
    {
        $data = array_merge($this->whereData, $data);

        $this->parseQuery($data);

        $conn = $this->database->get();

        $stmt = $conn->prepare($this->query);
        $stmt->execute($data);

        return str_starts_with(strtolower($this->query), 'insert')
            ? $conn->lastInsertId()
            : ['data' => $stmt->fetchAll(PDO::FETCH_OBJ), 'rows' => $stmt->rowCount()];
    }

    private function parseQuery($data)
    {
        $keys = array_keys($data);

        preg_match('/^[\w]+/i', $this->query, $match);

        switch(strtolower($match[0])) {
            case 'insert':
                    $bindings = array_map(fn($i) => ':' . $i, $keys);

                    $this->query = str_replace(
                        ['{{columns}}', '{{values}}'],
                        [implode(', ', $keys), implode(', ', $bindings)],
                        $this->query
                    );
                break;
            case 'update':

                    $bindings = array_map(fn($i) => $i . ' = ' . ':' . $i, $keys);

                    $this->query = str_replace('{{columns}}', implode(', ', $bindings), $this->query);

                break;
        }
    }
}