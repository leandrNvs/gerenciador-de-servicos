<?php

namespace Src\Routing;

use Src\Exception\HttpMethodNotAllowedException;

final class Routes
{
    /**
     * Set of defined routes
     *
     * @var array
     */
    private $routes = [];

    /**
     * Set of allowed http verbs
     *
     * @var array
     */
    private $allowedVerbs = ['get', 'delete', 'put', 'patch', 'post'];

    /**
     * Initialize the routes
     *
     * @param \Src\Routing\RouteUtilitites $utilities
     * @return void
     */
    public function __construct(private RouteUtilities $utilities) {}

    /**
     * Initialize the routes
     *
     * @param string $name
     * @param array  $arguments
     * @return \Src\Routing\RouteUtilitites
     *
     * @throws \Src\Exception\HttpMethodNotAllowedException
     */
    public function __call($name, $arguments)
    {
        if(in_array($name, $this->allowedVerbs)) {
            $this->addRoute($arguments[0], $name, $arguments[1]);

            return $this->utilities->route($arguments[0], $name);
        }

        throw new HttpMethodNotAllowedException("Http verb {$name} is not allowed to definition.");
    }

    /**
     * Set a new route to the routes
     *
     * @param string $uri
     * @param string $verb
     * @param Closure|array $closure
     * @return void
     */
    private function addRoute($uri, $verb, $closure)
    {
        $this->routes[$uri][$verb] = $closure;
    }

    /**
     * Get all defined routes
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
