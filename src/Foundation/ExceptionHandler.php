<?php

namespace Src\Foundation;

use Src\Exception\ValidationException;
use Src\Routing\Redirect;
use Throwable;

final class ExceptionHandler
{
    /**
     * Starts to listen to exceptions
     * @return void
     */
    public function listen()
    {
        set_exception_handler(function(Throwable $exception) {

            if($exception instanceof ValidationException) {
                Redirect::back();
            }

            die($exception->getMessage() . ' | ' . $exception->getFile());
        });
    } 
}
