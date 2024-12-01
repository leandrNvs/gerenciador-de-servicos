<?php

namespace Src\Routing;

class Routes
{
    private static $verbs = ['get', 'post', 'delete', 'put', 'patch'];

    private static $instance;

    private $routes = [];

    private $namedRoutes = [];

    public static function __callStatic($name, $arguments)
    {
        if(!self::$instance):
            self::$instance = new static;
        endif;

        if(in_array($name, self::$verbs)):
            self::$instance->addRoute($arguments[0], $name, $arguments[1]);
        endif;        

        return self::$instance;
    }

    public function addRoute($uri, $httpMethod, $closure)
    {
        $this->routes[$uri][$httpMethod] = $closure;
    }

    public function name($name)
    {
        $lastRoute = array_keys($this->routes);
        $lastRoute = end($lastRoute);

        $this->namedRoutes[$name] = $lastRoute;

        return $this;
    }

    public function getAllNamedRoutes()
    {
        return $this->namedRoutes;
    }

    public function getAllRoutes()
    {
        return $this->routes;
    }

    public static function getNamedRoutes()
    {
        return self::$instance->getAllNamedRoutes();
    }

    public static function getRoutes()
    {
        return self::$instance->getAllRoutes();
    }
} 