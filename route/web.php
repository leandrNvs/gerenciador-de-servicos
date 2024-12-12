<?php

use App\Controllers\Pages;
use App\Controllers\Part;
use App\Controllers\Schemas;
use App\Controllers\ServiceInfo;
use App\Controllers\Services;
use Src\Support\Routing\Routes;

Routes::get('/', [Pages::class, 'index'])->name('pages.home');
Routes::get('/pagina/{page}', [Pages::class, 'index'])->name('pages.home-page');

Routes::get('/terminados', [Pages::class, 'finished'])->name('pages.finished');
Routes::get('/terminados/pagina/{page}', [Pages::class, 'finished'])->name('pages.finished-page');

Routes::get('/cliente', [Pages::class, 'create'])->name('pages.create');

Routes::get('/cliente/{id}', [Pages::class, 'detail'])->name('pages.details');

Routes::get('/cliente/{id}/alterar', [Pages::class, 'update'])->name('pages.update');

Routes::get('/cliente/{id}/alterar-servico', [Pages::class, 'updateService'])->name('pages.update-service');

Routes::get('/servico/{idserv}/part/{idpart}/apagar', [Part::class, 'delete'])->name('part.delete');
Routes::post('/servico/{idserv}/part/{idpart}/alterar', [Part::class, 'update'])->name('part.update');

Routes::get('/servico/{idserv}/servico/{idpart}/apagar', [ServiceInfo::class, 'delete'])->name('serviceinfo.delete');
Routes::post('/servico/{idserv}/servico/{idpart}/alterar', [ServiceInfo::class, 'update'])->name('serviceinfo.update');

Routes::post('/cliente', [Services::class, 'store'])->name('services.store');

Routes::post('/cliente/{id}/adicionar-servico', [Services::class, 'addService'])->name('services.add-service');

Routes::post('/cliente/{id}/pecas', [Services::class, 'part'])->name('services.part');

Routes::put('/cliente/{id}/alterar', [Services::class, 'update'])->name('services.update');

Routes::patch('/cliente/{id}/completar', [Services::class, 'completed'])->name('services.completed');

Routes::delete('/cliente/{id}/apagar', [Services::class, 'delete'])->name('services.delete');

Routes::get('/criar-tabelas', [Schemas::class, 'index'])->name('tables.create');