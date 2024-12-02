<?php

namespace App\Controllers;

use Src\Session\Session;
use Src\Validation\Validate;
use Src\Views\View;

class Pages
{
    public static function index()
    {
        View::render('home');
    }

    public static function create()
    {
        View::render('create-form');
    }

    public static function update()
    {
        View::render('update-form');
    }
}