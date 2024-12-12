<?php

namespace App\Models;

use Src\Exception\ModelNotFoundException;
use Src\Foundation\Application;
use Src\Support\Database\QueryBuilder;

use function Src\Helpers\modelToTable;

class Model
{
    private $data = [];

    private $oldData = [];

    public function __construct(
        protected $tableName,
        protected $primaryKey,
        $data,
    )
    {
        $this->populate($data);
    }

    public static function create($data)
    {
        $tableInfo = modelToTable(get_called_class());

        return Application::getInstance()->resolve(
            get_called_class(),
            [$tableInfo['tableName'], $tableInfo['primaryKey'], $data]
        );
    }

    private function populate($data)
    {
        foreach($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    public function store()
    {
        $id = QueryBuilder::table($this->tableName)
            ->insert()
            ->execute($this->data);

        $this->{$this->primaryKey} = $id;

        return $this;
    }

    public function save()
    {
        $result = QueryBuilder::table($this->tableName)
            ->update()
            ->where('id', $this->id)
            ->execute($this->data);

        return $result['rows'];
    }

    public function saveAsChild($object)
    {
        $foreignKey = strtolower("{$this->tableName}{$this->primaryKey}");

        $object->{$foreignKey} = $this->{$this->primaryKey};
        $object->store();

        return $object;
    }

    public function delete()
    {
        $result = QueryBuilder::table($this->tableName)
            ->delete()
            ->where('id', $this->id)
            ->execute();

        return $result['rows'];
    }

    public function checkForChanges($data)
    {
        foreach($data as $key => $value) {
            if($this->data[$key] != $value && !empty($value) && $key != $this->primaryKey) {
                $this->oldData[$key] = $this->data[$key];
                $this->data[$key] = $value;
            }
        }

        return $this;
    }

    public static function all()
    {
        $tableInfo = modelToTable(get_called_class());

        $data = QueryBuilder::table($tableInfo['tableName'])
            ->select()
            ->execute();

        return array_map(function($i) {
            return static::create($i);
        }, $data['data']);
    }

    public static function getById($id)
    {
        $tableInfo = modelToTable(get_called_class());

        $data = QueryBuilder::table($tableInfo['tableName'])
            ->select()
            ->where('id', $id)
            ->execute();

        if(empty($data['data'])) {
            throw new ModelNotFoundException("Model for {$tableInfo['tableName']} not found.");
        }

        return static::create(end($data['data']));
    }

    public static function where(...$args)
    {
        $tableInfo = modelToTable(get_called_class());

        $data = QueryBuilder::table($tableInfo['tableName'])
            ->select()
            ->where(...$args)
            ->execute();

        return array_map(function($i) {
            return static::create($i);
        }, $data['data']);
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
}
