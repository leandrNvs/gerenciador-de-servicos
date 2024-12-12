<?php

namespace Src\Http;

final class Request
{
    /**
     * User's input data
     * 
     * @var array
     */
    private $input;

    /**
     * Current request uri
     * 
     * @var string
     */
    private $currentRequestUri;

    /**
     * Current request method
     * 
     * @var string
     */
    private $currentRequestMethod;

    /**
     * Initialize the request
     * 
     * @return void
     */
    public function __construct()
    {
        $this->setCurrentRequestInfo();
        $this->setInput();
    }

    /**
     * Get the current request uri
     * 
     * @return string
     */
    public function getCurrentRequestUri()
    {
        return $this->currentRequestUri;
    }

    /**
     * Get the current request method
     * 
     * @return string
     */
    public function getCurrentRequestMethod()
    {
        return $this->currentRequestMethod;
    }

    /**
     * Get a input data
     * 
     * @param string $name
     * @param mixed  $default
     * @return mixed
     */
    public function input($name, $default = null)
    {
        return $this->input[$name] ?? $default;
    }
 
    /**
     * Get all input data
     * 
     * @return array
     */
    public function all()
    {
        return $this->input;
    }

    public function is($route)
    {
        return $this->currentRequestUri === $route;
    }

    public function url()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * Set the information about the current request
     * 
     * @return void
     */
    private function setCurrentRequestInfo()
    {
        $this->currentRequestUri = $_SERVER['REQUEST_URI'];
        $this->currentRequestMethod = strtolower($_POST['_method'] ?? $_SERVER['REQUEST_METHOD']);

        unset($_POST['_method']);
    }

    /**
     * Set the user's input data
     * 
     * @return void
     */
    private function setInput()
    {
        $this->input = $_POST;

        $_POST = [];
    }
}
