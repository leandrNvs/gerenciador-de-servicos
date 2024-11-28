<?php

namespace App\Database;

use Src\Database\Database;

final class Tables
{
    
    public static function createTables()
    {
        $client = Database::createTableIf('client', [
            'name'    => 'VARCHAR(50) NOT NULL',
            'contact' => 'VARCHAR(11) NOT NULL'
        ]);

        $car = Database::createTableIf('car', [
            'brand'   => 'VARCHAR(30) NOT NULL',
            'model'   => 'VARCHAR(30) NOT NULL',
            'plate'   => 'VARCHAR(10) NOT NULL',
            'year'    => 'YEAR',
            'problem' => 'TEXT'
        ])->foreignKey($client);

        $service = Database::createTableIf('service', [
            'service' => 'TEXT',
            'price'  => 'DECIMAL'
        ])->foreignKey($client);

        $part = Database::createTableIf('part', [
            'part'          => 'VARCHAR(100) NOT NULL',
            'store'         => 'VARCHAR(100) NOT NULL',
            'price'         => 'DECIMAL NOT NULL',
            'purchase_date' => 'DATE NOT NULL',
            'seller'        => 'VARCHAR(50) NOT NULL'
        ])->foreignKey($client);

        $query = Database::getConnection();

        $query->query($client->query());
        $query->query($car->query());
        $query->query($service->query());
        $query->query($part->query());
    }

}
