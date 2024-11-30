<?php

use App\Models\Car;
use App\Models\Client;
use App\Models\Service;
use Src\Database\Database;
use Src\Database\Table;

require_once dirname(__DIR__) . '/vendor/autoload.php';

Database::initialize(dirname(__DIR__) . '/database/database.db');

var_dump(
    Table::schema(Client::class)
        ->identifier()
        ->varchar('name', 50)
        ->varchar('contact', 11)
        ->get()
);

var_dump(
    Table::schema(Car::class)
        ->identifier()
        ->varchar('brand', 30)
        ->varchar('type', 30)
        ->varchar('car_license_plate', 10)
        ->year('year')
        ->text('problem')
        ->foreignKeyFor(Client::class)
        ->get()
);

var_dump(
    Table::schema(Service::class)
        ->identifier()
        ->text('service')
        ->decimal('price')
        ->date('service_date')
        ->foreignKeyFor(Car::class)
        ->get()
);