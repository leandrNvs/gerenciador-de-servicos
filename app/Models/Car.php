<?php

namespace App\Models;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'plate',
        'color',
        'km',
        'fuel',
        'reported_defect',
        'problem_found'
    ];
}