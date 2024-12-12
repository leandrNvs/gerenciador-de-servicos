<?php

namespace Src\Filesystem;

use Src\Exceptions\FileNotFoundException;

final class Filesystem
{
    /**
     * Read a file if it exists
     *
     * @param string $file
     * @return string
     *
     * @throws \Src\Exceptions\FileNotFoundException
     */
    public function readFile($file)
    {
        if(!file_exists($file))
            throw new FileNotFoundException("File <b>{$file}</b> doens't exists.");

        return file_get_contents($file);
    }

    /**
     * Get the modification time
     *
     * @param string $file
     * @return int|false
     */
    public function getLastModification($file)
    {
        return filemtime($file);
    }

    /**
     * Write the dato to the file
     *
     * @param string $filename
     * @param string $data
     * @param bool   $append
     * @return void
     */
    public function writeFile($filename, $data, $append = false)
    {
        file_put_contents($filename, $data, $append? FILE_APPEND : 0);
    }

    /**
     * Get the directory path of a file
     * 
     * @param string $path
     * @return string
     */
    public function dirname($path)
    {
        return dirname($path);
    }

    /**
     * Make a directory if it not exist.
     *
     * @param string $filename
     * @param string $data
     * @param bool   $append
     * @return void
     */
    public function mkdir($dir)
    {
        if(!file_exists($dir)) {
            mkdir($dir);
        }
    }
}
