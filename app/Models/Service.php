<?php

namespace App\Models;

use Src\Database\Database;
use Src\Foundation\Application;
use Src\Support\Database\QueryBuilder;

use function Src\Helpers\modelToTable;

final class Service extends Model
{
    public function info()
    {
        $table = modelToTable(ServiceInfo::class);

        $foreignKey = strtolower("{$this->tableName}{$this->primaryKey}");
        
        $info = QueryBuilder::table($table['tableName'])
            ->select()
            ->where($foreignKey, $this->{$this->primaryKey})
            ->execute();
        
        $this->servicesInfo = array_map(fn($i) => ServiceInfo::create($i), $info['data']);

        return $this;
    }

    public function parts()
    {
        $table = modelToTable(Part::class);

        $foreignKey = strtolower("{$this->tableName}{$this->primaryKey}");
        
        $info = QueryBuilder::table($table['tableName'])
            ->select()
            ->where($foreignKey, $this->{$this->primaryKey})
            ->execute();
        
        $this->parts = array_map(fn($i) => Part::create($i), $info['data']);

        return $this;
    }

    public static function paginate($page, $quantity, $status = 0) 
    {
        $items = QueryBuilder::table('service')
            ->select()
            ->where('completed', $status)
            ->limit($quantity)
            ->offset($quantity * ((int) $page - 1))
            ->execute();

        $items = array_map(fn($i) => Service::create($i), $items['data']);

        $conn = Application::getInstance()[Database::class]->get();

        $res = $conn->query("SELECT COUNT(id) as pages FROM service WHERE completed = {$status}");

        return [
            'items' => $items,
            'quantity' => $res->fetch()['pages']
        ];
    }
}