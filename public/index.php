<?php
define('ROOT', dirname(__DIR__));

use App\Controllers\Pages;
use Src\Database\Database;
use Src\Http\Kernel;
use Src\Http\Request;
use Src\Routing\Routes;
use Src\Views\View;

require_once ROOT . '/vendor/autoload.php';

Database::initialize(ROOT . '/database/database.db');
View::path(ROOT . '/views/');

Routes::get('/', [Pages::class, 'index'])->name('pages.home');

Routes::get('/criar-novo-registro', [Pages::class, 'create'])->name('pages.create');

Routes::get('/cliente/{id}/atualizar', [Pages::class, 'update'])->name('pages.update');

Routes::delete('/cliente/{id}/apagar', fn() => 'deleting')->name('client.delete');

$response = Kernel::handle(Request::capture());

die($response);