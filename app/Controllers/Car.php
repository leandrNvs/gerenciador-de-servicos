<?php

namespace App\Controllers;

class Car
{
    const RULES = [
        'brand' => 'alpha|min:1',
        'model' => 'alphanumeric|min:1',
        'year'  => 'numeric|min:1|max:4',
        'plate' => 'alphanumeric|min:1',
        'color' => 'alpha|min:1',
        'km'    => 'numeric|min:1',
        'fuel'  => 'numeric|min:1',
        'reported_defect' => 'optional|alphanumeric|max:500',
        'problem_found'   => 'optional|alphanumeric|max:500',
    ];

    const UPDATE_RULES = [
        'brand' => 'optional|alpha|min:1',
        'model' => 'optional|alphanumeric|min:1',
        'year'  => 'optional|numeric|min:1|max:4',
        'plate' => 'optional|alphanumeric|min:1',
        'color' => 'optional|alpha|min:1',
        'km'    => 'optional|numeric|min:1',
        'fuel'  => 'optional|numeric|min:1',
        'reported_defect' => 'optional|alphanumeric|max:500',
        'problem_found'   => 'optional|alphanumeric|max:500',
    ];
}