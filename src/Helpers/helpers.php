<?php

namespace Src\Helpers;

use ReflectionClass;
use Src\Routing\Routes;

function route($name, $data = [])
{
    $route = Routes::getNamedRoutes()[$name];

    $keys = array_map(fn($i) => "{{$i}}", array_keys($data));

    $route = str_replace($keys, $data, $route);

    return $route;
}

function assets($asset)
{
    return '/assets/' . $asset;
}

function getClassInfo($class)
{
    $reflection = new ReflectionClass($class);

    $primaryKey = $reflection->getProperty('primaryKey')->getDefaultValue();

    $tableName = explode('\\', $reflection->getName());
    $tableName = strtolower(end($tableName));

    return [$tableName, $primaryKey, $class];
}