<?php

namespace Src\Session;

final class Session
{

    public static function set($name, $values)
    {
        $_SESSION[$name] = $values;
    }
    
    public static function get($name)
    {
        $data = $_SESSION[$name] ?? null;

        unset($_SESSION[$name]);

        return $data;
    }
}