<?php

namespace App\Models;

use Src\Validation\Validation;

final class Car extends Model
{
    public static function create_rules() 
    {
        return [
            'car_brand' => [Validation::REQUIRED, Validation::ALPHA],
            'car_model' => [Validation::REQUIRED, Validation::ALPHA],
            'car_color' => [Validation::REQUIRED, Validation::ALPHA],
            'car_year'  => [Validation::REQUIRED, Validation::YEAR],
            'car_plate' => [Validation::REQUIRED, Validation::ALPHANUMERIC],
            'car_km'    => [Validation::REQUIRED, Validation::DECIMAL],
            'car_fuel'  => [Validation::REQUIRED, Validation::DECIMAL],
            'car_reported_defect' => [Validation::OPTIONAL, Validation::ALPHANUMERIC, Validation::maxlength(500)],
            'car_problem_found'   => [Validation::OPTIONAL, Validation::ALPHANUMERIC, Validation::maxlength(500)],
        ];
    }

    public static function update_rules() 
    {
        return [
            'car_brand' => [Validation::OPTIONAL, Validation::ALPHA],
            'car_model' => [Validation::OPTIONAL, Validation::ALPHA],
            'car_color' => [Validation::OPTIONAL, Validation::ALPHA],
            'car_year'  => [Validation::OPTIONAL, Validation::YEAR],
            'car_plate' => [Validation::OPTIONAL, Validation::ALPHANUMERIC],
            'car_km'    => [Validation::OPTIONAL, Validation::DECIMAL],
            'car_fuel'  => [Validation::OPTIONAL, Validation::DECIMAL],
            'car_reported_defect' => [Validation::OPTIONAL, Validation::ALPHANUMERIC, Validation::maxlength(500)],
            'car_problem_found'   => [Validation::OPTIONAL, Validation::ALPHANUMERIC, Validation::maxlength(500)],
        ];
    }
}
