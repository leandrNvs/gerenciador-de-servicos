<?php

namespace App\Controllers;

use App\Models\Service;
use Src\Support\View\View;

final class Pages
{

    public static function index($page = 1)
    {
        [$items, $quantity] = array_values(Service::paginate($page, 20, 0));

        $active = 'home';
        $link = '/pagina';

        $totalPages = ceil($quantity / 20);

        return View::render('home', compact('items', 'page', 'active', 'link', 'totalPages'));
    }

    public static function finished($page = 1)
    {
        [$items, $quantity] = array_values(Service::paginate($page, 20, 1));

        $active = 'finished';
        $link = '/terminados/pagina';

        $totalPages = ceil($quantity / 20);

        return View::render('home', compact('items', 'page', 'active', 'link', 'totalPages'));
    }

    public static function create()
    {
        return View::render('form/create-form');
    }

    public static function update(Service $service)
    {
        $service->client_name = ucwords($service->client_name);

        return View::render('form/update-form', compact('service'));
    }
    public static function updateService(Service $service)
    {
        $service->info();
        $service->parts();

        $service->client_name = ucwords($service->client_name);

        return View::render('form/service-form', compact('service'));
    }

    public static function detail(Service $service)
    {
        $service->info();
        $service->parts();

        $service->client_name = ucwords($service->client_name);

        return View::render('detail', compact('service'));
    }
}
