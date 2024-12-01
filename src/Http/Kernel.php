<?php

namespace Src\Http;

use Closure;
use LDAP\Result;
use ReflectionFunction;
use ReflectionMethod;
use Src\Routing\Routes;

final class Kernel
{
    public static function handle(Request $request)
    {
        $routes = Routes::getRoutes();

        $verb = $request->getCurrentRequestMethod();
        $uri = $request->getCurrentRequestUri();

        foreach($routes as $pattern => $method):
            $pattern = self::pattern($pattern);

            if(preg_match("/^{$pattern}$/", $uri, $match)):
                unset($match[0]);

                return self::execute($method[$verb], $match);
            endif;
        endforeach;
    }

    private static function execute($closure, $parameters = [])
    {
        $reflection = is_array($closure)
            ? new ReflectionMethod($closure[0], $closure[1])
            : new ReflectionFunction($closure);

        $params = $reflection->getParameters();

        if(isset($params[0]) && $params[0]->getType()?->getName() === Request::class):
            array_unshift($parameters, Request::getInstance());
        endif;

        return call_user_func($closure, $parameters);
    }

    private static function pattern($pattern)
    {
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = preg_replace('/\{[^\/]+\}/', '([^\/]+)', $pattern);

        return $pattern;
    }
}