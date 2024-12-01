<?php

namespace Src\Helpers;

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