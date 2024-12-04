<?php

namespace Src\Http;

use Src\Utilities\Input;

class Request
{
    private static $instance;

    private $input;

    public function __construct()
    {
        $this->input = $_POST;
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

    public function input($input, $default = null)
    {
        return $this->input[$input] ?? $default;
    }

    public function inputParse($input, $default = null)
    {
        return new Input($this->input[$input] ?? $default);
    }

    public static function getInstance()
    {
        return self::$instance;
    }
}