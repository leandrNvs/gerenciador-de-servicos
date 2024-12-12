<?php

namespace Src\Validation;

use Src\Exception\ValidationException;

use function Src\Helpers\flash;

final class Validation
{
    const REQUIRED = 'required';
    const ALPHA = 'alpha';
    const NUMERIC = 'numeric';
    const ALPHANUMERIC = 'alphanumeric';
    const PHONE = 'phone';
    const CPF = 'cpf';
    const DATE = 'date';
    const YEAR = 'year';
    const DECIMAL = 'decimal';
    const TEXT = 'text';
    const OPTIONAL = 'optionial';
    const PERCENT = 'percent';

    const VALIDATE_HAS_ERROR = 'validade_has_error';
    const VALIDATE_ERR_MESSAGES = 'validate_err_messages';
    const VALIDATE_FORM_DATA = 'validate_form_data';

    public static function validate($rules, $data)
    {
        $errors = [];

        foreach($rules as $field => $rule) {
            $hasOptional = array_search(static::OPTIONAL, $rule);

            $skip = $hasOptional !== false && empty(trim($data[$field]));

            if(!$skip) {
                foreach($rule as $r) {
                    if(static::validation($r, $field, $data[$field])) {
                        $errors[$field][] = static::messages($r);
                    }
                }
            }
        }

        if(!empty($errors)) {
            flash()->set(static::VALIDATE_HAS_ERROR, true);
            flash()->set(static::VALIDATE_ERR_MESSAGES, $errors);
            flash()->set(static::VALIDATE_FORM_DATA, $data);
            throw new ValidationException();
        }

        return $data;
    }

    public static function maxlength($max)
    {
        return fn($value) => strlen($value) > $max;
    }

    private static function validation($rule, $field, $value)
    {
        switch($rule) {
            case static::REQUIRED:
                    return empty(trim($value));
                break;
            case static::TEXT:
                    return !preg_match('/^[a-zA-Z\,\.\s\-]+$/', $value);
                break;
            case static::ALPHA:
                    return !preg_match('/^[a-zA-Z\s]+$/', $value);
                break;
            case static::NUMERIC:
                    return !preg_match('/^[0-9]+$/', $value);
                break;
            case static::ALPHANUMERIC:
                    return !preg_match('/^[a-zA-Z0-9\,\.\s\-]+$/', $value);
                break;
            case static::PHONE:
                    return !preg_match('/^\([0-9]{2}\)\s[0-9]{5}\-[0-9]{4}$/', $value);
                break;
            case static::CPF:
                break;
            case static::DATE:
                    return preg_match('/^$/', $value);
                break;
            case static::YEAR:
                    return !preg_match('/^[0-9]{4}$/', $value);
                break;
            case static::DECIMAL:
                    return !preg_match('/^[0-9\,\.]+$/', $value);
                break;
        }
    }

    private static function messages($rule)
    {
        $messages = [
            static::REQUIRED => 'O campo é obrigatório',
            static::ALPHA => 'O campo deve conter apenas letras',
            static::NUMERIC => 'O campo deve conter apenas números',
            static::ALPHANUMERIC => 'O campo deve conter apenas letras e números',
            static::PHONE => 'phone',
            static::CPF => 'cpf',
            static::DATE => 'date',
            static::YEAR => 'year',
            static::DECIMAL => 'O campo deve conter apenas números, ponto ou vírgula',
            static::TEXT => 'text',
        ];
    
        return $messages[$rule];
    }
}
