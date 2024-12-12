<?php

namespace Src\Support\Routing;

use Src\Routing\RouteUtilities as RoutingRouteUtilities;
use Src\Support\Facades;

class RouteUtilities extends Facades
{
    protected static function getAccessor()
    {
        return RoutingRouteUtilities::class;
    }
}
