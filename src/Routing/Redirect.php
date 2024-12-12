<?php

namespace Src\Routing;

use function Src\Helpers\route;

final class Redirect
{
    /**
     * Redirect to a defined route
     * 
     * @param string $path
     * @return void
     */
    public static function to($path)
    {
        die(header('Location: ' . $path));
    }

    /**
     * Go back to the previous page
     * 
     * @return void
     */
    public static function back()
    {
        static::to($_SERVER['HTTP_REFERER']);
    }

    /**
     * Redirect to a named route
     */
    public static function route($name, $data = [])
    {
        $route = route($name, $data);

        static::to($route);
    }
}