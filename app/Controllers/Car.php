<?php

namespace App\Controllers;

use Src\Http\Request;

class Car
{
    const RULES = [
        'brand' => 'alpha|min:1',
        'model' => 'alphanumeric|min:1',
        'year' => 'numeric|min:1|max:4',
        'plate' => 'alphanumeric|min:1',
        'color' => 'alpha|min:1',
        'km' => 'numeric|min:1',
        'fuel' => 'numeric|min:1',
        'reported_defect' => 'optional|alphanumeric|max:500',
        'problem_found' => 'optional|alphanumeric|max:500',
    ];
}