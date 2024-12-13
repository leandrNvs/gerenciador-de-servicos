<?php

namespace Src\Session;

final class Flash
{
    const STATUS = 'flash_status';
    const MESSAGE = 'flash_message';

    /**
     * Get a flash bag for a given name
     * 
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        $data = $_SESSION[$name] ?? null;

        unset($_SESSION[$name]);

        return $data;
    }

    /**
     * Set a flash bag for a given name
     * 
     * @param string $name
     * @param mixed  $data
     * @return void
     */
    public function set($name, $data)
    {
        $_SESSION[$name] = $data;
    }

}