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
  <h1>Atualização de dados</h1>

  <div class="filters">
    <div class="panes">
      <a href="<?=htmlspecialchars(route('pages.update', ['id' => $service->id]))?>">Atualização de dados</a>
      <a href="<?=htmlspecialchars(route('pages.update-service', ['id' => $service->id]))?>" class="active">Informações do serviço prestado</a>
    </div>
  </div>

  <form action="<?=htmlspecialchars(route('services.add-service', ['id' => $service->id]))?>" class="form-serviceinfo" method="POST" autocomplete="off">
    <h2>1. informações sobre o serviço prestado</h2>

    <table>
      <thead>
        <tr>
          <th>Serviço prestado</th>
          <th>Valor do desconto</th>
          <th>Valor do serviço</th>
          <th>Total</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($service->servicesInfo as $info): ?>
          <tr>
            <td><?=htmlspecialchars($info->service_detail)?></td>
            <td><?=htmlspecialchars($info->service_descount)?>%</td>
            <td>R$ <?=htmlspecialchars($info->service_price)?></td>
            <td>R$ <?=htmlspecialchars((float)$info->service_price - ((100 - (int) $info->service_descount) / 100))?></td>
            <td>
              <a href="<?= route('serviceinfo.delete', ['idserv' => $service->id,'idpart' => $info->id]) ?>"><img src="/assets/images/x.svg" alt=""></a>
              <?php $data = ['detail' => $info->service_detail, 'descount' => $info->service_descount, 'price' => $info->service_price] ?>
              <a href="javascript:void(0)" onclick="updateInfo('<?=route('serviceinfo.update', ['idserv' => $service->id,'idpart' => $info->id])?>', '<?=htmlspecialchars(json_encode($data))?>')"><img src="/assets/images/pen.svg" alt=""></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div>
        
<div class="form-control">
  <div class="label">
    <label for="service_detail">Descrição do serviço</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['service_detail'][0] ?? null?></span>
  </div>
  <div class="input-control textarea">
    <textarea name="service_detail" id="service_detail" rows="7"><?=htmlspecialchars($view_form_data['service_detail'] ?? '')?></textarea>
  </div>
</div>

    </div>
    <div class="row">
        
<div class="form-control">
  <div class="label">
    <label for="service_price">Valor do serviço</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['service_price'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="service_price" id="service_price" value="<?=htmlspecialchars($view_form_data['service_price'] ?? '')?>" />
  </div>
</div>

        
<div class="form-control">
  <div class="label">
    <label for="service_descount">Desconto aplicado</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['service_descount'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="service_descount" id="service_descount" value="<?=htmlspecialchars($view_form_data['service_descount'] ?? '')?>" />
  </div>
</div>

    </div>

    <div class="form-buttons">
      <button type="submit">Adicionar informações</button>
      <a href="/">Cancelar</a>
    </div>
  </form>
</section>

<section class="container" style="margin-top: 2rem;">
  <form action="<?=htmlspecialchars(route('services.part', ['id' => $service->id]))?>" method="POST" class="form-part" autocomplete="off">
    <h2>2. informações sobre as peças</h2>
    
    <table>
      <thead>
        <tr>
          <th>Local da compra</th>
          <th>Vendedor</th>
          <th>Data da compra</th>
          <th>Peça</th>
          <th>Quantidade</th>
          <th>Preço</th>
          <th>Total</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($service->parts as $info): ?>
          <tr>
            <td><?=htmlspecialchars($info->part_place)?></td>
            <td><?=htmlspecialchars($info->part_seller)?></td>
            <td><?=htmlspecialchars($info->part_date_purchase ?? '')?></td>
            <td><?=htmlspecialchars($info->part_name)?></td>
            <td><?=htmlspecialchars($info->part_quantity)?></td>
            <td>R$ <?=htmlspecialchars($info->part_price)?></td>
            <td>R$ <?=htmlspecialchars((float) $info->part_price * (float) $info->part_quantity)?></td>
            <td>
              <a href="<?= route('part.delete', ['idserv' => $service->id,'idpart' => $info->id]) ?>"><img src="/assets/images/x.svg" alt=""></a>
              <?php $data = ['place' => $info->part_place, 'seller' => $info->part_seller, 'date' => $info->part_date_purchase, 'name' => $info->part_name, 'price' => $info->part_price, 'quantity' => $info->part_quantity] ?>
              <a href="javascript:void(0)" onclick="updatePart('<?=route('part.update', ['idserv' => $service->id,'idpart' => $info->id])?>', '<?=htmlspecialchars(json_encode($data))?>')"><img src="/assets/images/pen.svg" alt=""></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="row">
        
<div class="form-control">
  <div class="label">
    <label for="part_seller">Nome do vendedor</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['part_seller'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="part_seller" id="part_seller" value="<?=htmlspecialchars($view_form_data['part_seller'] ?? '')?>" />
  </div>
</div>

        
<div class="form-control">
  <div class="label">
    <label for="part_place">Local da compra</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['part_place'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="part_place" id="part_place" value="<?=htmlspecialchars($view_form_data['part_place'] ?? '')?>" />
  </div>
</div>

        
<div class="form-control">
  <div class="label">
    <label for="part_date_purchase">Data da compra</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['part_date_purchase'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="part_date_purchase" id="part_date_purchase" value="<?=htmlspecialchars($view_form_data['part_date_purchase'] ?? '')?>" />
  </div>
</div>

    </div>
    <div class="row">
        
<div class="form-control">
  <div class="label">
    <label for="part_name">Peça</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['part_name'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="part_name" id="part_name" value="<?=htmlspecialchars($view_form_data['part_name'] ?? '')?>" />
  </div>
</div>

        
<div class="form-control">
  <div class="label">
    <label for="part_price">Valor da peça</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['part_price'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="part_price" id="part_price" value="<?=htmlspecialchars($view_form_data['part_price'] ?? '')?>" />
  </div>
</div>

        
<div class="form-control">
  <div class="label">
    <label for="part_quantity">Quantidade comprada</label>
    <span class="<?= $view_has_form_err? 'active' : '' ?>">* <?=$view_form_err['part_quantity'][0] ?? null?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="part_quantity" id="part_quantity" value="<?=htmlspecialchars($view_form_data['part_quantity'] ?? '')?>" />
  </div>
</div>

    </div>


    <div class="form-buttons">
      <button type="submit">Adicionar informações</button>
      <a href="/">Cancelar</a>
    </div>
  </form>
</section>

  <script src="/assets/js/form.js"></script>
</body>
</html>