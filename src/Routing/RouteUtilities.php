<?php

namespace Src\Routing;

use Src\Exception\RouteNameAlreadySetException;

final class RouteUtilities
{
    /**
     * The last route information
     * 
     * @var array
     */
    private $lastAddedRouteInfo;

    /**
     * The named routes
     *
     * @var array
     */
    private $namedRoutes = [];

    /**
     * Set the las route information
     *
     * @param string $uri
     * @param string $verb
     * @return \Src\Routing\RouteUtilities
     */
    public function route($uri, $verb)
    {
        $this->lastAddedRouteInfo = compact('uri', 'verb');

        return $this;
    }

    /**
     * Name a route
     * @param string $name
     * @return \Src\Routing\RouteUtilities
     *
     * @throws \Src\Exception\RouteNameAlreadySetException
     */
    public function name($name)
    {
        if(isset($this->namedRoutes[$name])) {
            throw new RouteNameAlreadySetException("The name {$name} is already in use.");
        }

        $this->namedRoutes[$name] = $this->lastAddedRouteInfo['uri'];

        return $this;
    }

    public function getNamedRoute($name)
    {
        return $this->namedRoutes[$name] ?? false;
    }
}
