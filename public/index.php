<?php
session_start();

use Src\Routing\Redirect;
use Src\Validation\ValidateException;

define('ROOT', dirname(__DIR__));

set_exception_handler(function(Throwable $ex) {
    if($ex instanceof ValidateException):
        Redirect::back();
    endif;

    die($ex->getMessage());
});

use App\Controllers\Client;
use App\Controllers\Pages;
use App\Controllers\Table;
use Src\Database\Database;
use Src\Http\Kernel;
use Src\Http\Request;
use Src\Routing\Routes;
use Src\Views\View;

require_once ROOT . '/vendor/autoload.php';

/**
 * =================================================================
 *  INITIALIZATION
 * =================================================================
 */
Database::initialize(ROOT . '/database/database.sqlite');
View::path(ROOT . '/views/');

/**
 * =================================================================
 *  GET ROUTES
 * =================================================================
 */
Routes::get('/', [Pages::class, 'index'])->name('pages.home');

Routes::get('/criar-novo-registro', [Pages::class, 'create'])->name('pages.create');

Routes::get('/cliente/{id}/atualizar', [Pages::class, 'update'])->name('pages.update');

Routes::get('/create-tables', [Table::class, 'index']);

/**
 * =================================================================
 *  POST ROUTES
 * =================================================================
 */
Routes::post('/client', [Client::class, 'store'])->name('client.store');

/**
 * =================================================================
 *  DELETE ROUTES
 * =================================================================
 */
Routes::delete('/cliente/{id}/apagar', fn() => 'deleting')->name('client.delete');

/**
 * =================================================================
 *  HANDLE REQUEST AND RESPONSE
 * =================================================================
 */
$response = Kernel::handle(Request::capture());

die($response);