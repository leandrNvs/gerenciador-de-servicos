<?php

namespace App\Controllers;

use App\Models\Car;
use App\Models\Client;
use App\Models\Service;
use Src\Views\View;

class Pages
{
    public static function index()
    {
        $data = Client::with(Car::class);

        View::render('home', compact('data'));
    }

    public static function show($id)
    {
        $data = Client::getById($id)->car();

        View::render('details', compact('data'));
    }

    public static function create()
    {
        View::render('create-form');
    }

    public static function update($id)
    {
        $data = Client::getById($id)->car();

        View::render('update-form', compact('data'));
    }
}