<?php

namespace Src\Validation;

use Closure;
use Src\Session\Session;

class Validate 
{
    const VALIDATE_ERROR = 'validate_error';
    const VALIDATE_BAG = 'validate_bag';
    const VALIDATE_MESSAGES = 'validate_messages';

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function partial($fields)
    {
        $fields = array_map('trim', explode(',', $fields));

        $data = [];

        foreach($this->data as $key => $value):
            if(in_array($key, $fields)):
                $data[$key] = $this->data[$key];
            endif;
        endforeach;

        return $data;
    }

    public static function validate($validation, $data)
    {
        $messages = [];

        foreach($data as $key => $value):
            $rules = explode('|', $validation[$key]);

            $skip = (in_array('optional', $rules) && $value === '');

            if(!$skip):
                if(in_array('optional', $rules)) {
                    array_splice($rules, array_search('optional', $rules));
                }

                foreach($rules as $rule):
                    $parameters = explode(':', $rule);

                    array_push($parameters, $value);

                    if($msg = self::try(...$parameters)):
                        $messages[$key][] = $msg;
                    endif;
                endforeach;
            endif;
        endforeach;

        if(!empty($messages)):
            Session::set(self::VALIDATE_ERROR, true);
            Session::set(self::VALIDATE_BAG, $data);
            Session::set(self::VALIDATE_MESSAGES, $messages);
            throw new ValidateException;
        endif;

        return new static($data);
    }

    private static function try(...$parameters)
    {
        $rules = [
            'alpha' => [
                'rule' => fn(...$value) => !preg_match("/^[a-zA-Z\s]+$/", $value[0]),
                'message' => 'o campo deve conter apenas letras e espaços.'
            ],
            'numeric' => [
                'rule' => fn(...$value) => !preg_match("/^[0-9]+$/", $value[0]),
                'message' => 'o campo deve conter apenas números.'
            ],
            'alphanumeric' => [
                'rule' => fn(...$value) => !preg_match("/^[0-9a-zA-Z\s]+$/", $value[0]),
                'message' => 'o campo deve conter apenas letras, números e espaços.'
            ],
            'min' => [
                'rule' => fn(...$value) => $value[0] > strlen($value[1]),
                'message' => fn(...$value) => $value[0] === 1? 'o campo é obrigatório' : "o campo deve conter no mínimo {$value[0]} caracteres."
            ],
            'max' => [
                'rule' => fn(...$value) => $value[0] < strlen($value[1]),
                'message' => fn(...$value) => "o campo deve conter no máximo {$value[0]} caracteres."
            ],
        ];

        $index = array_shift($parameters);

        if($rules[$index]['rule'](...$parameters)):
            return ($m = $rules[$index]['message']) instanceof Closure
                ? $m(...$parameters)
                : $m;
        else:
            return false;
        endif;
    }
}

// const validation = {
// };