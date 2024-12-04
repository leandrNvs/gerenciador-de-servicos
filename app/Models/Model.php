<?php

namespace App\Models;

use Reflection;
use ReflectionClass;
use Src\Database\QueryBuilder;

use function Src\Helpers\getClassInfo;

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
        [$parentTable, $parentPrimaryKey, $className] = getClassInfo(get_called_class());

        $models = is_array($model)? $model : [$model];

        $children = [];

        foreach($models as $m):
            $children['child' . count($children) + 1] = getClassInfo($m);
        endforeach;

        $parent = QueryBuilder::table($parentTable)->select()->execute();

        $parentIds = array_column($parent['data'], 'id');

        $parent = array_map(function($model) use($className) {
            return call_user_func([$className, 'create'], $model);
        }, $parent['data']);


        $foreignKey = $parentTable . $parentPrimaryKey;

        $childrenData = [];

        foreach($children as $key => $value):
            $chld = array_map(function($model) use($value) {
                return call_user_func([$value[2], 'create'], $model);
            }, QueryBuilder::table($value[0])->select()->whereIn($foreignKey, $parentIds)->execute()['data']);

            $childrenData[$key] = $chld;
        endforeach;

        foreach($parent as $p):
            foreach($childrenData as $key => $value):
                $filtered = array_filter($value, function($model) use($p, $foreignKey) {
                    return $model->{$foreignKey} == $p->id;
                });

                $p->{$children[$key][0]} = end($filtered);
            endforeach;
        endforeach;

        return $parent;
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