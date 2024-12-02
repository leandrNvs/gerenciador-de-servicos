<?php

namespace App\Controllers;

use App\Models\Client;
use App\Models\Car;
use App\Models\Service;
use Src\Database\Database;
use Src\Database\Table as TableSchema;

final class Table
{
    public static function index()
    {
        $client = TableSchema::schema(Client::class);

        $client->identifier();
        $client->varchar('name', 50);
        $client->varchar('phone', 11);
        $client->varchar('cpf', 11);
        $client->varchar('address', 50);

        $car = TableSchema::schema(Car::class);

        $car->identifier();
        $car->varchar('brand', 20);
        $car->varchar('model', 20);
        $car->year('year');
        $car->varchar('plate', 15);
        $car->varchar('color', 20);
        $car->varchar('km', 15);
        $car->varchar('fuel', 15);
        $car->text('reported_defect');
        $car->text('problem_found');
        $car->foreignKeyFor(Client::class);

        $service = TableSchema::schema(Service::class);

        $conn = Database::getInstance();

        $conn->query($client->get());
        $conn->query($car->get());
    }
}