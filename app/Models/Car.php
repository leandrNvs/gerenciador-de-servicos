<?php

namespace App\Models;

class Car extends Model
{
    protected $fillable = ['brand', 'type', 'year', 'problem', 'car_license_plate'];
}