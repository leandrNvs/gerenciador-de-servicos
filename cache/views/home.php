<?php use function Src\Helpers\route; use function Src\Helpers\request; use function Src\Helpers\hasError; use function Src\Helpers\err; use function Src\Helpers\bag; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JRC - Página inicial</title>
  <link rel="stylesheet" href="/assets/css/home.css">
</head>
<body>
  <div class="overlay">
    <form action="" method="POST">
      <input type="hidden" name="_method" value="delete" />
      <h2>Confirme a exclusão do serviço</h2>
      <div>
        <input type="hidden" name="id" value="">
        <p>Tem certeza que deseja apagar os dados de <b class="label"></b>?</p>
        <button type="submit">Confirmar</button>
        <button type="reset" onclick="closeConfirmDeleteBox()">Cancelar</button>
      </div>
    </form>
  </div>

  <form action="" method="POST" class="form-toggleComplete" style="display:none;">
    <input type="hidden" name="_method" value="patch" />
    <input type="hidden" name="id" value="">
  </form>

  <main class="container">
    <div class="header">
      <h1>Orderns de serviço</h1>
      <a href="<?= route('pages.create') ?>">Adicionar novo serviço</a>
    </div>

    <div class="filters">
      <div class="panes">
        <a href="<?= route('pages.home') ?>" class="<?= $active == 'home' ? 'active' : '' ?>">Serviços em andamento</a>
        <a href="<?= route('pages.finished') ?>" class="<?= $active == 'finished' ? 'active' : '' ?>">Serviços concluídos</a>
      </div>
      <form class="search-form" autocomplete="off">
        <input type="search" name="search" id="search" placeholder="Procure por serviços aqui...">
      </form>
    </div>

    <table class="services">
      <thead>
        <tr>
          <th>
            <div>ID <img src="/assets/images/arrow.svg" alt=""></div>
          </th>
          <th>
            <div>Nome <img src="/assets/images/arrow.svg" alt=""></div>
          </th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Cor</th>
          <th>Problema</th>
          <th>Data de início</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($items as $item): ?>
          <tr data-update="<?=htmlspecialchars(route('pages.update', ['id' => $item->id]))?>" data-completed="<?=htmlspecialchars(route('services.completed', ['id' => $item->id]))?>" data-delete="<?=htmlspecialchars(route('services.delete', ['id' => $item->id]))?>" data-name="<?=htmlspecialchars($item->client_name)?>" data-id="<?=htmlspecialchars($item->id)?>" oncontextmenu="actions(event, this)">
            <td><?=htmlspecialchars(str_pad($item->id, '8', '0', STR_PAD_LEFT))?></td>
            <td><a href="<?=htmlspecialchars(route('pages.details', ['id' => $item->id]))?>"><?=htmlspecialchars($item->client_name)?></a></td>
            <td><?=htmlspecialchars($item->car_brand)?></td>
            <td><?=htmlspecialchars($item->car_model)?></td>
            <td><?=htmlspecialchars($item->car_color)?></td>
            <td class="problem"><?=htmlspecialchars($item->car_problem_found)?></td>
            <td><?=htmlspecialchars(date_format(date_create($item->created_at), "d/m/Y"))?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>

  <div class="paginate">
    <p>Exibindo página <?=$page?> de <?=htmlspecialchars($totalPages)?></p>
    <div class="pagina-buttons">
      <?php if(!($page == 1)): ?>
        <a href="<?=$link?>/<?=$page-1?>">&lt;&lt;</a>
      <?php endif; ?>
      <?php for($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?=$link?>/<?=$i?>" class="<?= $page == $i? 'active' : '' ?>"><?=$i?></a>
      <?php endfor; ?>
      <?php if(!($page == $totalPages)): ?>
        <a href="<?=$link?>/<?=$page+1?>">&gt;&gt;</a>
      <?php endif; ?>
    </div>
  </div>

  <div class="actions">
    <a href="javascript:void(0)" onclick="toggleComplete()">Marcar/desmarcar como concluído</a>
    <a href="#" class="actions-update">Alterar dados</a>
    <a href="javascript:void(0)" onclick="showConfirmDeleteBox()">Apagar item</a>
  </div>

  <div class="flash-messages <?=$view_flash_success? 'active' : ''?>">
    <?=($message = $view_flash_message)? $message : null?>
  </div>

  <script src="/assets/js/home.js"></script>
</body>
</html>
