<?php

namespace App\Models;

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

        $this->table = strtolower(get_class($this));
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
     * Get the table name
     * 
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
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