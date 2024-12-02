<?php

namespace Src\Database;

use Closure;
use Exception;

final class QueryBuilder
{
    private $query;

    private $table;

    private $where;

    private $whereData = [];

    private $orderBy;

    private $limit;

    public function __construct($table) {
        $this->table = $table;
    }

    public function __call($name, $arguments)
    {
        $this->query = match($name) {
            'select' => 'SELECT '. (empty($arguments)? '*' : $arguments[0]) .' FROM {{table}} ',
            'delete' => 'DELETE FROM {{table}} ',
            'update' => 'UPDATE {{table}} SET {{columns}} ',
            'insert' => 'INSERT INTO {{table}} ({{columns}}) values ({{values}})'
        };

        $this->query = str_replace('{{table}}', $this->table, $this->query);

        return $this;
    }

    public static function table($table)
    {
        return new static($table);
    }

    public function where(...$args)
    {
        $this->getWhereData($args);

        if(!$this->where):
            $this->where = "WHERE {$args[0]} " . (count($args) === 2? "= :{$args[0]}" : "{$args[1]} :{$args[0]}");
        else:

            if($args[0] instanceof Closure):
                $this->where .= ' AND (';
                $args[0]($this);
                $this->where .= ')';

                $this->where = preg_replace('/\( AND /', '(', $this->where);
            else:
                $this->where .= " AND {$args[0]} " . (count($args) === 2? "= :{$args[0]}" : "{$args[1]} :{$args[0]}");
            endif;

        endif;

        return $this;
    }

    public function orWhere(...$args)
    {
        $this->getWhereData($args);

        if($args[0] instanceof Closure):
            $this->where .= ' OR (';
            $args[0]($this);
            $this->where .= ')';

            $this->where = preg_replace('/\( AND /', '(', $this->where);
        else:
            $this->where .= " OR {$args[0]} " . (count($args) === 2? "= :{$args[0]}" : "{$args[1]} :{$args[0]}");
        endif;
        
        return $this;
    }

    public function whereNot(...$args)
    {
        $this->getWhereData($args);

        if(!$this->where):
            $this->where = "WHERE NOT {$args[0]} " . (count($args) === 2? "= :{$args[0]}" : "{$args[1]} :{$args[0]}");
        else:

            if($args[0] instanceof Closure):
                $this->where .= ' AND (';
                $args[0]($this);
                $this->where .= ')';

                $this->where = preg_replace('/\( AND /', '(', $this->where);
            else:
                $this->where .= " AND NOT {$args[0]} " . (count($args) === 2? "= :{$args[0]}" : "{$args[1]} :{$args[0]}");
            endif;

        endif;

        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        if(!$this->orderBy):
            $this->orderBy = "ORDER BY {$column} {$direction}";
        else:
            $this->orderBy .= ", {$column} {$direction}";
        endif;

        return $this;
    }

    public function limit($num)
    {
        $this->limit = "LIMIT {$num}";

        return $this;
    }

    public function execute($data)
    {
        $this->query = $this->mountFields(
            $this->query . $this->where . $this->orderBy . $this->limit,
            $data
        );

        $data = array_merge($this->whereData, $data);

        $conn = Database::getInstance();

        $stmt = $conn->prepare($this->query);
        $stmt->execute($data);

        return str_starts_with(strtolower($this->query), 'insert')
            ? $conn->lastInsertId()
            : ['data' => $stmt->fetchAll(), 'rows' => $stmt->rowCount()];
    }

    private function getWhereData($data)
    {
        if(count($data) === 2):
            $this->whereData[$data[0]] = $data[1];
        else:
            $this->whereData[$data[0]] = $data[2];
        endif;
    }

    private function mountFields($query, $data)
    {
        preg_match("/^[\w]+/", $query, $match);

        $operation = strtolower(end($match));

        switch($operation):
            case 'select':
                break;
            case 'update':

                    $keys = array_keys($data);
                    $column = array_map(fn($i) => "{$i} = :{$i}", $keys);

                    $query = str_replace('{{columns}}', implode(', ', $column), $query);

                break;
            case 'delete':
                break;
            case 'insert':
                    $keys = array_keys($data);
                    $bindings = array_map(fn($i) => ":{$i}", $keys);

                    $query = str_replace([
                        '{{columns}}',
                        '{{values}}'
                    ], [
                        implode(', ', $keys),
                        implode(', ', $bindings)
                    ], $query);

                break;
            default:
                throw new Exception("Invalid sql operation.");
        endswitch;

        return $query;
    }

    public function get($data)
    {
        $this->query = $this->mountFields(
            $this->query . $this->where . $this->orderBy . $this->limit,
            $data
        );

        return $this->query;
    }
}