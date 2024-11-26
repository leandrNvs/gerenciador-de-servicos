<?php

use Src\Http\Kernel;
use Src\Http\Request;
use Src\Routing\Routes;
use Src\View\View;

require_once "../vendor/autoload.php";

View::path(dirname(__DIR__) . '/views/');

Routes::get('/', function() {
    return View::render('home');
});

Routes::get('/cliente/{id}', function($id) {
    return $id;
});

$response = Kernel::send(Request::capture());

die($response);
