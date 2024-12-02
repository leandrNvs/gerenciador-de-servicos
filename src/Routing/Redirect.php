<?php

namespace Src\Routing;

final class Redirect
{
    public static function to($path)
    {
        die(header('Location: '. $path));
    }

    public static function back()
    {
        self::to($_SERVER['HTTP_REFERER']);
    }
}