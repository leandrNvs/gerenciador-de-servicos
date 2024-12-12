<?php

namespace Src\Http;

use App\Models\Model;
use Closure;
use ReflectionFunction;
use ReflectionMethod;
use Src\Exception\HttpMethodNotFoundException;
use Src\Exception\RouteNotFoundException;
use Src\Foundation\Application;
use Src\Routing\Routes;

final class Kernel
{
    /**
     * Initialize the kernel
     *
     * @param \Src\Foundation\Application $app
     * @param \Src\Http\Request $request
     * @param \Src\Routing\Routes $routes
     * @return void
     */
    public function __construct(
        private Application $app,
        private Request $request,
        private Routes $routes
    ) {

        require_once $app['routes'] . 'web.php';
    }

    /**
     * Initialize the capture of the request
     * 
     * @throws \Src\Exception\RouteNotFoundException
     * @throws \Src\Exception\HttpMethodNotFoundException
     *
     * @return void
     */
    public function capture()
    {
        $routes = $this->routes->getRoutes();

        $uri = $this->request->getCurrentRequestUri();
        $verb = $this->request->getCurrentRequestMethod();

        foreach($routes as $pattern => $route) {
            $pattern = $this->toPattern($pattern, $parameters);

            if(preg_match($pattern, $uri, $matches)) {
                if(!isset($route[$verb])) throw new HttpMethodNotFoundException("Verb {$verb} not found for route {$uri}");

                unset($matches[0]);

                return $this->execute($route[$verb], $matches, $parameters);
            }
        }

        throw new RouteNotFoundException("Route {$uri} not found");
    }


    /**
     * Execute the match route
     * 
     * @param Closure $route
     * @param array   $parameters
     * @param array   $parametersName
     * @return mixed
     */
    private function execute($route, $parameters, $parametersName)
    {
        $reflection = $route instanceof Closure
            ? new ReflectionFunction($route)
            : new ReflectionMethod($route[0], $route[1]);

        if(!($dependencies = $reflection->getParameters())) {
            return call_user_func($route, ...$parameters);
        }

        $dp = [];

        foreach($dependencies as $dependence) {
            if(($class = $dependence->getType()?->getName()) && class_exists($class)) {
                if(is_a($class, Model::class, true)) {
                    if(str_starts_with(array_pop($parametersName), 'id')) {
                        $dp[] =  $class::getById(array_shift($parameters));
                    }
                } else {
                    $dp[] = $this->app->build($class);
                }
            }
        }

        $parameters = array_merge($dp, $parameters);

        return call_user_func($route, ...$parameters);
    }

    /**
     * Transform the key of a route into a pattern regex
     * 
     * @param string $pattern
     * @param mixed  $parameters
     * @return string
     */
    private function toPattern($pattern, &$parameters)
    {
        $pattern = str_replace('/', '\/', $pattern);

        preg_match_all('/\{([^\/]+?)\}/', $pattern, $match);

        $pattern = str_replace($match[0], '([^\/]+?)', $pattern);

        $parameters = $match[1];

        return "/^{$pattern}$/";
    }
}
