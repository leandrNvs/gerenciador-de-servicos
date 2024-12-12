<?php

namespace Src\Foundation;

use Src\Filesystem\Filesystem;

final class Application extends Container
{
    /**
     * Initialize the application
     *
     * @param string $path
     * @return void
     */
    public function __construct(private $path)
    { 
        session_start();

        $this->setBaseBindings();
        $this->setBasePaths();

        $this[ExceptionHandler::class]->listen();

        $this->setBaseDirectories();
    }

    /**
     * Configure the base binds for the application
     *
     * @return void
     */ 
    protected function setBaseBindings()
    {
        static::setInstance($this);

        $this->instance(Application::class, $this);
        $this->instance(Container::class, $this);

        $this->singleton(ExceptionHandler::class);
        $this->singleton(Filesystem::class);
    }

    /**
     * Configure the base paths for the application
     *
     * @return void
     */ 
    protected function setBasePaths()
    {
        $this->instance('cache', $this->getPath('/cache/'));
        $this->instance('routes', $this->getPath('/route/'));
        $this->instance('views.base', $this->getPath('/views/'));
        $this->instance('views.cache', $this->getPath('/cache/views/'));
        $this->instance('database', $this->getPath('/database/'));
    }

    /**
     * Build the base directories for the application
     *
     * @return void
     */
    protected function setBaseDirectories()
    {
        $filesystem = $this[Filesystem::class];

        $filesystem->mkdir($this['cache']);
        $filesystem->mkdir($this['routes']);
        $filesystem->mkdir($this['views.base']);
        $filesystem->mkdir($this['views.cache']);
        $filesystem->mkdir($this['database']);
    }

    /**
     * Get the paths based on the root path
     *
     * @param string $path
     * @return string
     */
    protected function getPath($path = null)
    {
        return $this->path . $path;
    }
}
