<?php

namespace App\Models;

use Src\Validation\Validation;

final class Part extends Model
{
    public static function create_rules()
    {
        return [
            'part_place'    => [Validation::REQUIRED, Validation::ALPHANUMERIC],
            'part_seller'   => [Validation::REQUIRED, Validation::ALPHA],
            'part_name'     => [Validation::REQUIRED, Validation::ALPHANUMERIC],
            'part_price'    => [Validation::REQUIRED, Validation::DECIMAL],
            'part_quantity' => [Validation::REQUIRED, Validation::NUMERIC],
            'part_date_purchase' => [Validation::OPTIONAL, Validation::DATE],
        ];
    }

    public static function update_rules()
    {
        return [
            'part_place'    => [Validation::OPTIONAL, Validation::ALPHANUMERIC],
            'part_seller'   => [Validation::OPTIONAL, Validation::ALPHA],
            'part_name'     => [Validation::OPTIONAL, Validation::ALPHANUMERIC],
            'part_price'    => [Validation::OPTIONAL, Validation::DECIMAL],
            'part_quantity' => [Validation::OPTIONAL, Validation::NUMERIC],
            'part_date_purchase' => [Validation::OPTIONAL, Validation::DATE],
        ];
    }
}