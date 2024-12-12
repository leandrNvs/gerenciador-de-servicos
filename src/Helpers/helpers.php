<?php

namespace Src\Helpers;

use ReflectionClass;
use Src\Foundation\Application;
use Src\Http\Request;
use Src\Routing\Redirect;
use Src\Session\Flash;
use Src\Support\Routing\RouteUtilities;

function route($name, $data = [])
{
    $route = RouteUtilities::getNamedRoute($name);

    if($route) {
        $keys = array_map(fn($i) => "{{$i}}", array_keys($data));
        $route = str_replace($keys, $data, $route);
    }

    return $route;
}

function request()
{
    return Application::getInstance()[Request::class];
}

function flash()
{
    return Application::getInstance()[Flash::class];
}

function to_route($name, $data = [])
{
    return Redirect::route($name, $data);
}

function modelToTable($model)
{
    $reflection = new ReflectionClass($model);

    $parameters = $reflection->getDefaultProperties();

    $table = explode('\\', $model);

    return [
        'tableName' => $parameters['tableName'] ?? strtolower(end($table)),
        'primaryKey' => $parameters['primaryKey'] ?? 'id',
    ];
}

