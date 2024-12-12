<?php

namespace Src\Support;

use Exception;
use Src\Foundation\Application;

class Facades
{
    public static function __callStatic($name, $arguments)
    {
        return Application::getInstance()[static::getAccessor()]->{$name}(...$arguments);
    }

    protected static function getAccessor()
    {
        throw new Exception("Acessor for {get_called_class()} not defined");
    }
}
