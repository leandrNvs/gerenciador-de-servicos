<?php

namespace App\Models;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'cpf', 'address'];
}