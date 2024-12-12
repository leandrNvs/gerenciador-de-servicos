<?php use function Src\Helpers\route; use function Src\Helpers\request; use function Src\Helpers\hasError; use function Src\Helpers\err; use function Src\Helpers\bag; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JRC - Criar novo serviço</title>
  <link rel="stylesheet" href="/assets/css/form.css" />
</head>
<body>
  




<section class="container">
  <h1>Atualização de dados </h1>

  <div class="filters">
    <div class="panes">
      <a href="<?=htmlspecialchars(route('pages.update', ['id' => $service->id]))?>" class="active">Atualização de dados</a>
      <a href="<?=htmlspecialchars(route('pages.update-service', ['id' => $service->id]))?>">Informações do serviço prestado</a>
    </div>
  </div>

  <form action="<?=htmlspecialchars(route('services.update', ['id' => $service->id]))?>" method="POST" autocomplete="off">
    <input type="hidden" name="_method" value="put" />
    <h2>1. dados do cliente</h2>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="name">Nome do cliente</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['client_name'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="client_name" id="name" placeholder="<?=htmlspecialchars($service->client_name)?>" value="<?=htmlspecialchars($view_form_data['client_name'] ?? '')?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="phone">Telefone</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['client_phone'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="client_phone" id="phone" placeholder="<?=htmlspecialchars($service->client_phone)?>" value="<?=htmlspecialchars($view_form_data['client_phone'] ?? '')?>" />
  </div>
</div>

    </div>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="cpf">CPF</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['client_cpf'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="client_cpf" id="cpf" placeholder="<?=htmlspecialchars($service->client_cpf)?>" value="<?=htmlspecialchars($view_form_data['client_cpf'] ?? '')?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="address">Endereço</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['client_address'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="client_address" id="address" placeholder="<?=htmlspecialchars($service->client_address)?>" value="<?=htmlspecialchars($view_form_data['client_address'] ?? '')?>" />
  </div>
</div>

    </div>

    <h2>2. dados do veículo</h2>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="brand">Marca</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['car_brand'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_brand" id="brand" placeholder="<?=htmlspecialchars($service->car_brand)?>" value="<?=htmlspecialchars($view_form_data['car_brand'] ?? '')?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="model">Modelo</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['car_model'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_model" id="model" placeholder="<?=htmlspecialchars($service->car_model)?>" value="<?=htmlspecialchars($view_form_data['car_model'] ?? '')?>" />
  </div>
</div>

    </div>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="year">Ano</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['car_year'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_year" id="year" placeholder="<?=htmlspecialchars($service->car_year)?>" value="<?=htmlspecialchars($view_form_data['car_year'] ?? '')?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="color">Cor</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['car_color'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_color" id="color" placeholder="<?=htmlspecialchars($service->car_color)?>" value="<?=htmlspecialchars($view_form_data['car_color'] ?? '')?>" />
  </div>
</div>

    </div>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="plate">Placa do veículo</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['car_plate'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_plate" id="plate" placeholder="<?=htmlspecialchars($service->car_plate)?>" value="<?=htmlspecialchars($view_form_data['car_plate'] ?? '')?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="km">KM atual</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['car_km'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_km" id="km" placeholder="<?=htmlspecialchars($service->car_km)?>" value="<?=htmlspecialchars($view_form_data['car_km'] ?? '')?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="fuel">Combustível</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['car_fuel'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_fuel" id="fuel" placeholder="<?=htmlspecialchars($service->car_fuel)?>" value="<?=htmlspecialchars($view_form_data['car_fuel'] ?? '')?>" />
  </div>
</div>

    </div>
    <div>
      
<div class="form-control">
  <div class="label">
    <label for="reported_defect">Problema informado</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['car_reported_defect'][0] ?? null?></span>
  </div>
  <div class="input-control textarea">
    <textarea name="car_reported_defect" id="reported_defect" placeholder="<?=htmlspecialchars($service->car_reported_defect)?>" rows="7"><?=htmlspecialchars($view_form_data['car_reported_defect'] ?? '')?></textarea>
    <div class="icon">!</div>
  </div>
</div>

    </div>
    <div>
      
<div class="form-control">
  <div class="label">
    <label for="problem_found">Problema detectado</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['car_problem_found'][0] ?? null?></span>
  </div>
  <div class="input-control textarea">
    <textarea name="car_problem_found" id="problem_found" placeholder="<?=htmlspecialchars($service->car_problem_found)?>" rows="7"><?=htmlspecialchars($view_form_data['car_problem_found'] ?? '')?></textarea>
    <div class="icon">!</div>
  </div>
</div>

    </div>

    <div class="form-buttons">
      <button type="submit">Salvar alterações</button>
      <a href="/">Cancelar</a>
    </div>
  </form>
</section>

  <script src="/assets/js/form.js"></script>
</body>
</html>