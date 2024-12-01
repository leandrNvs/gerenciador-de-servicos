<?php

namespace App\Controllers;

use App\Models\Car;
use App\Models\Client as ModelsClient;
use Src\Http\Request;

class Client
{

    public function store(Request $request)
    {
        $client = ModelsClient::create([
            'name'    => 'Leandro',
            'contact' => 'leandro@email.com'
        ])->save();

        $car = Car::create([
            'brand'   => '',
            'type'    => '',
            'year'    => '',
            'problem' => '',
            'car_license_plate' => '',
        ]);

        $client->saveAsChild($car);
    }

}