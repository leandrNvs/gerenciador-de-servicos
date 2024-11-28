<?php

namespace App\Models;

use Exception;
use Src\Database\Database;

class Model 
{
    private $data = [];

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name] ?? throw new Exception("{$name} not found.");
    }

    public function save()
    {
        $table = strtolower(explode('\\', get_class($this))[2]);

        $query = 'INSERT INTO '. $table .' ({{column}}) VALUES ({{values}});';

        $columns = array_keys($this->data);

        $query = str_replace('{{column}}', implode(', ', $columns), $query);

        $values = array_map(fn($i) => ":{$i}", $columns);

        $query = str_replace('{{values}}', implode(', ', $values), $query);

        $conn = Database::getConnection();

        $stmt = $conn->prepare($query);

        foreach($this->data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        $stmt->execute();

        $this->data['id'] = $conn->lastInsertRowId();

        return $this;
    }

    public function saveAsChild($object)
    {
        $fkField = strtolower(explode('\\', get_class($this))[2]) . 'id';

        $object->{$fkField} = $this->id;

        $object->save();

        return $this;
    }
}

