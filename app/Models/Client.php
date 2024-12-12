<?php

namespace App\Models;

use Src\Validation\Validation;

final class Client extends Model
{
    public static function create_rules()
    {
        return [
            'client_name'    => [Validation::REQUIRED, Validation::ALPHA],
            'client_cpf'     => [Validation::REQUIRED, Validation::CPF, Validation::maxlength(14)],
            'client_phone'   => [Validation::REQUIRED, Validation::PHONE, Validation::maxlength(15)],
            'client_address' => [Validation::REQUIRED, Validation::ALPHANUMERIC]
        ];
    }

    public static function update_rules()
    {
        return [
            'client_name'    => [Validation::OPTIONAL, Validation::ALPHA],
            'client_cpf'     => [Validation::OPTIONAL, Validation::CPF, Validation::maxlength(14)],
            'client_phone'   => [Validation::OPTIONAL, Validation::PHONE, Validation::maxlength(15)],
            'client_address' => [Validation::OPTIONAL, Validation::ALPHANUMERIC]
        ];
    }
}
