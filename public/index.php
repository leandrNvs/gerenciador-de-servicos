<?php
define('ROOT', dirname(__DIR__));

use App\Database\Tables;
use App\Models\Car;
use App\Models\Client;
use App\Models\Service;
use Src\Database\Database;
use Src\Http\Kernel;
use Src\Http\Request;
use Src\Routing\Redirect;
use Src\Routing\Routes;
use Src\View\View;

require_once "../vendor/autoload.php";

Database::initialize(ROOT . '/database/');
View::path(ROOT . '/views/');
// Tables::createTables();

Routes::get('/', function() {
    $conn = Database::getConnection();

    $result = $conn->query('SELECT c.id, c.name, r.brand, r.model, r.year FROM client as c INNER JOIN car as r ON c.id = r.clientid');

    $lines = '';

    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $lines .= <<<TR
            <tr data-id="{$row['id']}">
                <td><a href="/client/{$row['id']}">{$row['name']}</a></td>
                <td>{$row['brand']}</td>
                <td>{$row['year']}</td>
                <td>{$row['model']}</td>
                <td></td>
                <td></td>
            </tr>
        TR;
    }

    $result->finalize();

    return View::render('home', [
        'line' => $lines
    ]);
});

Routes::get('/cliente', function() {
    return View::render('form');
});

Routes::get('/cliente/{id}', function($id) {
    return View::render('details');
});

Routes::post('/create', function() {
    $data = json_decode(file_get_contents('php://input'));

    $client = new Client;
    $client->name = $data->client;
    $client->contact = $data->contact;

    $car = new Car;
    $car->brand = $data->brand;
    $car->model = $data->model;
    $car->year  = $data->year;
    $car->plate = $data->plate;
    $car->problem = $data->problem;

    $service = new Service;
    $service->service = $data->change_parts;
    $service->price   = $data->price;

    $connecion = Database::getConnection();

    $connecion->exec('BEGIN');

    $client->save()
        ->saveAsChild($car)
        ->saveAsChild($service);

    $connecion->exec('COMMIT');

    $connecion->close();
});

Routes::delete('/cliente/{id}/delete', function(Request $request, $id) { 

    var_dump($request->input('id'));
    exit;

    $conn = Database::getConnection();

    $stmt = $conn->prepare('DELETE FROM client WHERE id = :id;');
    $stmt->bindValue(':id', $id);

    $stmt->execute();

    Redirect::to('/');
});

$response = Kernel::send(Request::capture());

die($response);
