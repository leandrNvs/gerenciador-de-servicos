<?php

namespace Src\Http;

class Request
{
    private static $instance;

    public function __construct()
    {
    }

    public static function capture()
    {
        return self::$instance = new static;
    }

    public function getCurrentRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getCurrentRequestMethod()
    {
        $method = strtolower($_POST['_method'] ?? $_SERVER['REQUEST_METHOD']);

        unset($_POST['_method']);

        return $method;
    }

    public static function getInstance()
    {
        return self::$instance;
    }
}