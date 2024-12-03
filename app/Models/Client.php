<?php

namespace App\Models;

use Src\Database\QueryBuilder;

class Client extends Model
{
    protected $fillable = ['id', 'name', 'phone', 'cpf', 'address'];

    public function car()
    {
        $table = explode('\\', Car::class);
        $table = strtolower(end($table));

        $data = QueryBuilder::table($table)->select()->where('clientid', $this->id)->execute();

        $this->car = Car::create($data['data'][0]);

        return $this;
    }
}