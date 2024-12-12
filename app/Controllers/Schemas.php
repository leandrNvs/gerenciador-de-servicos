<?php

namespace App\Controllers;

use App\Models\Part;
use App\Models\Service;
use App\Models\ServiceInfo;
use Src\Database\Schemas as DatabaseSchemas;

final class Schemas
{
    public static function index()
    {
        $service = DatabaseSchemas::new(Service::class) ;

        $service->id();
        $service->varchar('client_name', 50);
        $service->varchar('client_phone', 15);
        $service->varchar('client_cpf', 15);
        $service->varchar('client_address', 50);
        $service->varchar('car_brand', 20);
        $service->varchar('car_model', 20);
        $service->year('car_year');
        $service->varchar('car_plate', 15);
        $service->varchar('car_color', 20);
        $service->varchar('car_km', 15);
        $service->varchar('car_fuel', 15);
        $service->text('car_reported_defect');
        $service->text('car_problem_found');
        $service->bool('completed')->default('false');
        $service->date('created_at')->default('CURRENT_DATE');

        $serviceInfo = DatabaseSchemas::new(ServiceInfo::class);

        $serviceInfo->id();
        $serviceInfo->text('service_detail')->optional();
        $serviceInfo->decimal('service_price')->optional();
        $serviceInfo->decimal('service_descount')->default('0');
        $serviceInfo->foreignKeyFor(Service::class);

        $parts = DatabaseSchemas::new(Part::class);

        $parts->id();
        $parts->varchar('part_name')->optional();
        $parts->varchar('part_seller')->optional();
        $parts->varchar('part_place')->optional();
        $parts->decimal('part_price')->optional();
        $parts->smallint('part_quantity')->optional();
        $parts->date('part_date_purchase')->optional();
        $parts->foreignKeyFor(Service::class);

        $conn = $service->database->get();

        $conn->query($service->get());
        $conn->query($serviceInfo->get());
        $conn->query($parts->get());
    }
}