<?php

namespace App\Models;

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
            ->get($this->data);

        $this->data[$this->primaryKey] = 1;

        return $this;
    }

    public function saveAsChild($object)
    {
        $fk = $this->getTableName() . $this->getPrimaryKey();

        $data = array_merge(
            $object->getData(),
            [$fk => $this->getId()]
        );

        $query = QueryBuilder::table($object->getTableName())
            ->insert()
            ->get($data);

        return $this;
    }

    public static function where(...$args)
    {

    }

    public static function getById($id)
    {
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