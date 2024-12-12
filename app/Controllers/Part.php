<?php

namespace App\Controllers;

use App\Models\Part as ModelsPart;
use App\Models\Service;
use Src\Http\Request;
use Src\Routing\Redirect;
use Src\Validation\Validation;

final class Part
{
    public static function delete(Service $service, ModelsPart $part)
    {
        if($service->id === $part->serviceid) {
            $part->delete();

            return Redirect::back();
        }
    }

    public static function update(Request $request, Service $service, ModelsPart $info)
    {
        $data = Validation::validate(
            array_merge(ModelsPart::update_rules()),
            $request->all()
        );

        $info->checkForChanges($data);

        $info->save();

        return Redirect::back();
    }
}