<?php

namespace App\Models;

use Reflection;
use ReflectionClass;
use Src\Database\QueryBuilder;

class Model
{
    /**
     * The table's name
     * 
     * @var string
     */
    protected $table;

    /**
     * Allowed fields to insert data
     * 
     * @var array
     */
    protected $fillable = [];

    /**
     * The table's primary key
     * 
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The model's data
     * 
     * @var array
     */
    private $data = [];

    /**
     * Instantiate a new object
     * 
     * @param array $data
     * @return void
     */
    public function __construct($data)
    {
        $this->populate($data);
        if(!$this->table) $this->setTableName();
    }
    
    /**
     * Create a new model's instance
     * 
     * @param array $data
     * @return static
     */
    public static function create($data)
    {
        return new static($data);
    }

    /**
     * Insert data into the object
     * 
     * @param array $data
     * @return void
     */
    private function populate($data)
    {
        foreach($data as $key => $value):
            if(in_array($key, $this->fillable)):
                $this->data[$key] = $value;
            endif;
        endforeach;
    }

    /**
     * Get the primary key name for the table
     * 
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * Get all the data
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the model's id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->data[$this->primaryKey];
    }

    /**
     * Determina the table name
     * 
     * @return void
     */
    private function setTableName()
    {
        $table = explode('\\', get_class($this));

        $this->table = strtolower(end($table));
    }

    /**
     * Get the table name
     * 
     * @return string
     */
    public function getTableName()
    {
        return strtolower($this->table);
    }

    public function save()
    {
        $query = QueryBuilder::table($this->getTableName())
            ->insert()
            ->execute($this->data);

        $this->id = $query;

        return $this;
    }

    public function saveAsChild($object)
    {
        $fk = $this->getTableName() . $this->getPrimaryKey();

        $data = array_merge(
            $object->getData(),
            [$fk => $this->getId()]
        );

        QueryBuilder::table($object->getTableName())
            ->insert()
            ->execute($data);

        return $this;
    }

    public function update($data)
    {
        foreach($data as $key => $value):
            if($value === '' || $value == $this->data[$key]):
                unset($data[$key]);
            else:
                $this->data[$key] = $value;
            endif;
        endforeach;

        if(empty($data)) return;

        QueryBuilder::table($this->getTableName())->update()->where('id', $this->id)->execute($data);

        return $this;
    }

    public function delete()
    {
        QueryBuilder::table($this->getTableName())
            ->delete()
            ->where('id', $this->id)
            ->execute();

        return $this;
    }

    public static function with($model)
    {
        $first = new ReflectionClass(get_called_class());

        $primaryKey = $first->getProperty('primaryKey')->getDefaultValue();

        $tableName = explode('\\', $first->getName());
        $tableName = strtolower(end($tableName));

        $second = new ReflectionClass($model);

        $tableName2 = explode('\\', $second->getName());
        $tableName2 = strtolower(end($tableName2));

        $data1 = QueryBuilder::table($tableName)->select()->execute();

        $ids = array_column($data1['data'], 'id');

        $col = $tableName . $primaryKey;

        $data2 = QueryBuilder::table($tableName2)->select()->whereIn($col, $ids)->execute();

        $data = [];

        foreach($data1['data'] as $d):
            $model = call_user_func([get_called_class(), 'create'], $d);

            $id = $model->id;

            $item = array_filter($data2['data'], function($i) use($id, $col) {
                return $i->{$col} == $id;
            });

            $model->{$tableName2} = call_user_func([$second->getName(), 'create'], end($item));

            array_push($data, $model);
        endforeach;

        return $data;
    }

    public static function where(...$args)
    {

    }

    public static function getById($id)
    {
        $tableName = explode('\\', get_called_class());
        $table = strtolower(end($tableName));

        $query = QueryBuilder::table($table)->select()->where('id', $id)->execute();

        return call_user_func([implode('\\', $tableName), 'create'], $query['data'][0]);
    }

    /**
     * Set a piece of data
     * 
     * @param string $name
     * @param mixed  $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Retrieve date
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $class = get_class($this);

        return $this->data[$name] ?? throw new \Exception("Property <b>{$name}</b> doesn't exists in <b>{$class}</b> class");
    }
}