<?php

namespace Src\Views;

use Exception;
use Src\Session\Session;
use Src\Validation\Validate;

final class View
{
    private static $path;

    public static function path($path)
    {
        self::$path = $path;
    }

    public static function render($view, $data = [])
    {
        $file = self::$path . $view . '.html';

        if(!file_exists($file)):
            throw new Exception("<b>{$view}</b> doesn't exists.");
        endif;

        $cachedFile = self::$path . 'cache/' . $view  . '.php';

        $baseFileModifiedTime = filemtime($file);
        $cachedFileModifiedTime = file_exists($cachedFile)? filemtime($cachedFile) : 0;

        $wasModified = $baseFileModifiedTime > $cachedFileModifiedTime;

        if($wasModified):
            file_put_contents($cachedFile ,Template::parse(file_get_contents($file)));
        endif;

        $data['template_error'] = Session::get(Validate::VALIDATE_ERROR);
        $data['template_messages'] = Session::get(Validate::VALIDATE_MESSAGES);
        $data['template_bag'] = Session::get(Validate::VALIDATE_BAG);

        foreach($data as $key => $value):
            $$key = $value; 
        endforeach;

        require_once $cachedFile;
    }
}