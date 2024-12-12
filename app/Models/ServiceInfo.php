<?php

namespace App\Models;

use Src\Validation\Validation;

final class ServiceInfo extends Model
{
    public static function create_rules()
    {
        return [
            'service_detail'   => [Validation::REQUIRED, Validation::TEXT],
            'service_price'    => [Validation::REQUIRED, Validation::DECIMAL],
            'service_descount' => [Validation::OPTIONAL, Validation::NUMERIC],
        ];
    }

    public static function update_rules()
    {
        return [
            'service_detail'   => [Validation::OPTIONAL, Validation::TEXT],
            'service_price'    => [Validation::OPTIONAL, Validation::DECIMAL],
            'service_descount' => [Validation::OPTIONAL, Validation::NUMERIC],
        ];
    }
}