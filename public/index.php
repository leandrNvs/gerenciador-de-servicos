<?php

use Src\Database\Database;
use Src\Foundation\Application;
use Src\Http\Kernel;
use Src\Http\Request;
use Src\Routing\Routes;
use Src\Routing\RouteUtilities;
use Src\Session\Flash;
use Src\View\View;

require '../vendor/autoload.php';

$app = new Application(dirname(__DIR__));

$app->singleton(Kernel::class);
$app->singleton(Request::class);
$app->singleton(Routes::class);
$app->singleton(View::class);
$app->singleton(RouteUtilities::class);
$app->singleton(Database::class);
$app->singleton(Flash::class);

echo $app[Kernel::class]->capture();
