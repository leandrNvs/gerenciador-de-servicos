<?php

namespace App\Controllers;

use App\Models\Car;
use App\Models\Client;
use App\Models\Part;
use App\Models\Service;
use App\Models\ServiceInfo;
use Src\Http\Request;
use Src\Routing\Redirect;
use Src\Session\Flash;
use Src\Validation\Validation;

use function Src\Helpers\flash;
use function Src\Helpers\to_route;

final class Services
{

    public static function store(Request $request)
    {
        $service = Service::create(Validation::validate(
            array_merge(Client::create_rules(), Car::create_rules()),
            $request->all()
        ));

        $service->client_name = strtolower($service->client_name);
        $service->car_fuel = preg_replace('/\,/', '.', $service->car_fuel);
        $service->car_km = preg_replace('/\,/', '.', $service->car_km);

        $service->store();

        flash()->set(Flash::MESSAGE, "Nova ordem de serviço para <b>{$service->client_name}</b>");

        return to_route('pages.home');
    }

    public static function update(Request $request, Service $service)
    {
        $data = (object) Validation::validate(
            array_merge(Client::update_rules(), Car::update_rules()),
            $request->all()
        );

        $data->client_name = strtolower($data->client_name);
        $data->car_fuel = preg_replace('/\,/', '.', $data->car_fuel);
        $data->car_km = preg_replace('/\,/', '.', $data->car_km);

        $service->checkForChanges($data);

        $service->save();

        $service->client_name = ucfirst($service->client_name);

        flash()->set(Flash::MESSAGE, "A ordem de serviço de <b>$service->client_name</b> foi alterada.");

        return to_route('pages.home');
    }

    public static function completed(Service $service)
    {
        $service->completed = $service->completed === 0? 1 : 0;

        $service->client_name = ucfirst($service->client_name);

        $service->save();

        if($service->completed) {
            flash()->set(Flash::MESSAGE, "A ordem de serviço de <b>$service->client_name</b> foi marcada como concluída.");
        } else {
            flash()->set(Flash::MESSAGE, "A ordem de serviço de <b>$service->client_name</b> foi marcada como não concluída.");
        }

        return to_route('pages.home');
    }

    public static function delete(Service $service)
    {
        $service->client_name = ucfirst($service->client_name);

        $service->delete();

        flash()->set(Flash::MESSAGE, "A ordem de serviço de <b>$service->client_name</b> foi apagada.");

        return to_route('pages.home');
    }

    public static function addService(Request $request, Service $service)
    {
        $serviceInFo = ServiceInfo::create(Validation::validate(
            ServiceInfo::create_rules(),
            $request->all()
        ));

        $service->saveAsChild($serviceInFo);

        return Redirect::back();
    }

    public static function part(Request $request, Service $service)
    {
        $part = Part::create(Validation::validate(
            Part::create_rules(),
            $request->all()
        ));

        $service->saveAsChild($part);

        return Redirect::back();
    }
}
