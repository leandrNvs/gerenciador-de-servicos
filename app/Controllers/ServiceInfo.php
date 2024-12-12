<?php

namespace App\Controllers;

use App\Models\Service;
use App\Models\ServiceInfo as ModelsServiceInfo;
use Src\Http\Request;
use Src\Routing\Redirect;
use Src\Validation\Validation;

final class ServiceInfo
{
    public static function delete(Service $service, ModelsServiceInfo $info)
    {
        if($service->id === $info->serviceid) {
            $info->delete();

            return Redirect::back();
        }
    }

    public static function update(Request $request, Service $service, ModelsServiceInfo $info)
    {
        $data = Validation::validate(
            array_merge(ModelsServiceInfo::update_rules()),
            $request->all()
        );

        $info->checkForChanges($data);

        $info->save();

        return Redirect::back();
    }
}