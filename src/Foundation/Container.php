<?php

namespace Src\Foundation;

use ArrayAccess;
use Closure;
use ReflectionClass;
use ReflectionException;
use Src\Exception\ClassNotFoundException;
use Src\Exception\TargetNotInstantiableException;

class Container implements ArrayAccess
{
    /**
     * The container's services
     *
     * @var array 
     */
    private $services = [];

    /**
     * The container's shared services
     *
     * @var array 
     */
    private $instances = [];

    /**
     * The container instance
     *
     * @var \Src\Foundation\Container
     */
    protected static $instance;

    /**
     * Set a new service to the container
     *
     * @param string              $abstract
     * @param Closure|string|null $concrete
     * @param bool                $shared
     * @return void
     */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        $concrete = $concrete ?? $abstract;

        if(is_string($concrete)) {
            $concrete = function($app, $parameters = []) use($concrete) {
                return $app->resolve($concrete, $parameters);
            };
        }

        $this->services[$abstract] = compact('concrete', 'shared');
    }

    /**
     * Set a new shared service to the container
     *
     * @param string              $abstract
     * @param Closure|string|null $concrete
     * @return void
     */
    public function singleton($abstract, $concrete = null)
    {
        $this->bind($abstract, $concrete, true);
    }

    /**
     * Set a instance to the container
     *
     * @param string $abstract
     * @param mixed  $instance
     * @return void
     */
    public function instance($abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }

    /**
     * Build a given type
     *
     * @param string $abstract
     * @param array  $parameters
     * @return mixed
     */ 
    public function build($abstract, $parameters = [])
    {
        if(($object = $this->instances[$abstract] ?? false)) {
            return $object;
        }

        $concrete = $this->getConcrete($abstract);

        $object = $concrete instanceof Closure
            ? $concrete($this, $parameters)
            : $this->resolve($concrete, $parameters);

        if($this->isShared($abstract)) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    /**
     * Try to resolve a given type and it's dependencies
     *
     * @param string $abstract
     * @param array  $parameters
     * @return mixed
     */
    public function resolve($abstract, $parameters)
    {
        try {
            $reflection = new ReflectionClass($abstract);
        } catch(ReflectionException $e) {
            throw new ClassNotFoundException("Target class [$abstract] not found.");
        }

        if(!$reflection->isInstantiable()) {
            throw new TargetNotInstantiableException("Target [$abstract] is not instantiable.");
        }

        $construct = $reflection->getConstructor();

        if(!$construct || !($dependencies = $construct->getParameters())) {
            return $reflection->newInstanceArgs();
        }

        $dp = [];

        foreach($dependencies as $dependence) {
            if(($type = $dependence->getType())) {
                if(($class = $type->getName()) && class_exists($class)) {
                    $dp[] = $this->build($class);
                } 
            }
        }

        $dp = array_merge($dp, $parameters);

        return $reflection->newInstanceArgs($dp);
    }

    /**
     * Get the concrete of the given type
     *
     * @param string $abstract
     * @return mixed
     */
    protected function getConcrete($abstract)
    {
        return $this->services[$abstract]['concrete'] ?? $abstract;
    }

    /**
     * Determine if the given type should be shared
     *
     * @param string $abstract
     * @return mixed
     */
    protected function isShared($abstract)
    {
        return $this->services[$abstract]['shared'] ?? null;
    }

    /**
     * Resolve the given type
     *
     * @param string $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->build($offset);
    }

    /**
     * Set a new service to the Container
     *
     * @param string         $offset
     * @param closure|string $offset
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->bind($offset, $value);
    }

    /**
     * Delete itens related to the given type
     *
     * @param string $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->services[$offset]);
        unset($this->instances[$offset]);
    }

    /**
     * Determine if the given type exists
     *
     * @param string $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->instances[$offset]) || isset($this->services[$offset]);
    }

    /**
     * Set the instance of the container
     *
     * @param \Src\Foundation\Container $instance
     * @return void
     */
    public static function setInstance(Container $instance)
    {
        static::$instance = $instance;
    }

    /**
     * Get the instance of the container
     *
     * @return \Src\Foundation\Container $instance
     */
    public static function getInstance()
    {
        return static::$instance;
    }
}
