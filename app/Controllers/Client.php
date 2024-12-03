<?php

namespace App\Controllers;

use App\Models\Car as ModelsCar;
use App\Models\Client as ModelsClient;
use Exception;
use Src\Http\Request;
use Src\Routing\Redirect;
use Src\Session\Flash;
use Src\Session\Session;
use Src\Validation\Validate;

class Client
{
    const RULES = [
        'name'    => 'alpha|min:1',
        'phone'   => 'numeric|min:11|max:11',
        'cpf'     => 'numeric|min:11|max:11',
        'address' => 'alphanumeric|min:1',
    ];

    const UPDATE_RULES = [
        'name'    => 'optional|alpha|min:1',
        'phone'   => 'optional|numeric|min:11|max:11',
        'cpf'     => 'optional|numeric|min:11|max:11',
        'address' => 'optional|alphanumeric|min:1',
    ];

    public static function store(Request $request)
    {
        $rules = array_merge(self::RULES, Car::RULES);

        $data = Validate::validate($rules, [
            'name'    => $request->input('name'),
            'phone'   => $request->input('phone'),
            'cpf'     => $request->input('cpf'),
            'address' => $request->input('address'),
            'brand'   => $request->input('brand'),
            'model'   => $request->input('model'),
            'year'    => $request->input('year'),
            'plate'   => $request->input('plate'),
            'color'   => $request->input('color'),
            'km'      => $request->input('km'),
            'fuel'    => $request->input('fuel'),
            'reported_defect' => $request->input('reported_defect'),
            'problem_found'   => $request->input('problem_found'),
        ]);

        $clientData = $data->partial('name, phone, cpf, address');
        $carData    = $data->partial('brand, model, year, plate, color, km, fuel, reported_defect, problem_found');

        $client = ModelsClient::create($clientData)->save();

        $car = ModelsCar::create($carData);

        $client->saveAsChild($car);

        Session::set(Flash::FLASH_MESSAGE, 'Nova ordem de serviço adicionada.');

        Redirect::to('/');
    }

    public static function update(Request $request, $id)
    {
        if($request->input('clientid') != $id)
            throw new Exception('Can\'t do it');

        $clientId = $request->input('clientid');

        $client = ModelsClient::getById($clientId)->car();

        $rules = array_merge(self::UPDATE_RULES, Car::UPDATE_RULES);

        $data = Validate::validate($rules, [
            'name'    => $request->input('name'),
            'phone'   => $request->input('phone'),
            'cpf'     => $request->input('cpf'),
            'address' => $request->input('address'),
            'brand'   => $request->input('brand'),
            'model'   => $request->input('model'),
            'year'    => $request->input('year'),
            'plate'   => $request->input('plate'),
            'color'   => $request->input('color'),
            'km'      => $request->input('km'),
            'fuel'    => $request->input('fuel'),
            'reported_defect' => $request->input('reported_defect'),
            'problem_found'   => $request->input('problem_found'),
        ]);

        $clientData = $data->partial('name, phone, cpf, address');
        $carData    = $data->partial('brand, model, year, plate, color, km, fuel, reported_defect, problem_found');

        $client->update($clientData);

        $client->car->update($carData);

        Session::set(Flash::FLASH_MESSAGE, "Os dados de {$client->name} foram atualizados.");

        Redirect::to('/');
    }

    public static function delete(Request $request, $id)
    {
        if($id != $request->input('id'))
            throw new Exception('Can\'t do it');

        $client = ModelsClient::getById($request->input('id'))->car();

        $client->car->delete();

        $client->delete();

        Session::set(Flash::FLASH_MESSAGE, "Os dados de {$client->name} foram foram apagados.");

        Redirect::to('/');
    }
}