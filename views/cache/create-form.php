<?php
  use function \Src\Helpers\assets;
  use function \Src\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JRC - Criar novo serviço</title>
  <link rel="stylesheet" href="<?= assets('css/form.css') ?>">
</head>
<body>

  <main>
    <div class="links">
      <a href="/">Página inicial</a>
      >
      <a href="/cliente" style="color: dodgerblue;">Cadastrar novo serviço</a>
    </div>
    <form action="<?= route('client.store') ?>" method="POST" autocomplete="off">

      <!-- CLIENTE -->
      <div class="client">
        <h3>Dados do cliente</h3>

        <div class="row">
          <div class="form-control">
            <label for="name">Nome</label>
            <input type="text" name="name" value="<?= isset($template_bag['name'])? $template_bag['name'] : null ?>" id="name" autofocus>
            <div class="message <?= ($template_error && isset($template_messages['name']))? 'active' : null ?>">
              <?php if(isset($template_messages['name'][0])): echo array_pop($template_messages['name']); endif; ?>
            </div>
          </div>

          <div class="form-control">
            <label for="phone">Telefone</label>
            <input type="text" name="phone" value="<?= isset($template_bag['phone'])? $template_bag['phone'] : null ?>" id="phone">
            <div class="message <?= ($template_error && isset($template_messages['phone']))? 'active' : null ?>">
              <?php if(isset($template_messages['phone'][0])): echo array_pop($template_messages['phone']); endif; ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-control">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" value="<?= isset($template_bag['cpf'])? $template_bag['cpf'] : null ?>" autofocus>
            <div class="message <?= ($template_error && isset($template_messages['cpf']))? 'active' : null ?>">
              <?php if(isset($template_messages['cpf'][0])): echo array_pop($template_messages['cpf']); endif; ?>
            </div>
          </div>

          <div class="form-control">
            <label for="address">Endereço</label>
            <input type="text" name="address" value="<?= isset($template_bag['address'])? $template_bag['address'] : null ?>" id="address">
            <div class="message <?= ($template_error && isset($template_messages['address']))? 'active' : null ?>">
              <?php if(isset($template_messages['address'][0])): echo array_pop($template_messages['address']); endif; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- CARRO -->
      <div class="cars">
        <h3>Dados do veículo</h3>
        <div class="row">
          <div class="form-control">
            <label for="brand">marca</label>
            <input type="text" name="brand" value="<?= isset($template_bag['brand'])? $template_bag['brand'] : null ?>" id="brand">
            <div class="message <?= ($template_error && isset($template_messages['brand']))? 'active' : null ?>">
              <?php if(isset($template_messages['brand'][0])): echo array_pop($template_messages['brand']); endif; ?>
            </div>
          </div>
          <div class="form-control">
            <label for="model">modelo</label>
            <input type="text" name="model" value="<?= isset($template_bag['model'])? $template_bag['model'] : null ?>" id="model">
            <div class="message <?= ($template_error && isset($template_messages['model']))? 'active' : null ?>">
              <?php if(isset($template_messages['model'][0])): echo array_pop($template_messages['model']); endif; ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-control">
            <label for="year">ano</label>
            <input type="text" name="year" value="<?= isset($template_bag['year'])? $template_bag['year'] : null ?>" id="year">
            <div class="message <?= ($template_error && isset($template_messages['year']))? 'active' : null ?>">
              <?php if(isset($template_messages['year'][0])): echo array_pop($template_messages['year']); endif; ?>
            </div>
          </div>
          <div class="form-control">
            <label for="plate">placa</label>
            <input type="text" name="plate" value="<?= isset($template_bag['plate'])? $template_bag['plate'] : null ?>" id="plate">
            <div class="message <?= ($template_error && isset($template_messages['plate']))? 'active' : null ?>">
              <?php if(isset($template_messages['plate'][0])): echo array_pop($template_messages['plate']); endif; ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-control">
            <label for="color">Cor</label>
            <input type="text" name="color" value="<?= isset($template_bag['color'])? $template_bag['color'] : null ?>" id="color" autofocus>
            <div class="message <?= ($template_error && isset($template_messages['color']))? 'active' : null ?>">
              <?php if(isset($template_messages['color'][0])): echo array_pop($template_messages['color']); endif; ?>
            </div>
          </div>

          <div class="form-control">
            <label for="km">KM atual</label>
            <input type="text" name="km" value="<?= isset($template_bag['km'])? $template_bag['km'] : null ?>" id="km">
            <div class="message <?= ($template_error && isset($template_messages['km']))? 'active' : null ?>">
              <?php if(isset($template_messages['km'][0])): echo array_pop($template_messages['km']); endif; ?>
            </div>
          </div>

          <div class="form-control">
            <label for="fuel">Combustível</label>
            <input type="text" name="fuel" value="<?= isset($template_bag['fuel'])? $template_bag['fuel'] : null ?>" id="fuel">
            <div class="message <?= ($template_error && isset($template_messages['fuel']))? 'active' : null ?>">
              <?php if(isset($template_messages['fuel'][0])): echo array_pop($template_messages['fuel']); endif; ?>
            </div>
          </div>
        </div>
        <div class="form-control">
          <label for="reported_defect">Defeito informado</label>
          <textarea name="reported_defect" id="reported_defect" rows="7"><?= isset($template_bag['reported_defect'])? $template_bag['reported_defect'] : null ?></textarea>
            <div class="message <?= ($template_error && isset($template_messages['reported_defect']))? 'active' : null ?>">
              <?php if(isset($template_messages['reported_defect'][0])): echo array_pop($template_messages['reported_defect']); endif; ?>
            </div>
        </div>
        <div class="form-control">
          <label for="problem_found">Defeito constatado</label>
          <textarea name="problem_found" id="problem_found" rows="7"><?= isset($template_bag['problem_found'])? $template_bag['problem_found'] : null ?></textarea>
            <div class="message <?= ($template_error && isset($template_messages['problem_found']))? 'active' : null ?>">
              <?php if(isset($template_messages['problem_found'][0])): echo array_pop($template_messages['problem_found']); endif; ?>
            </div>
        </div>
      </div>

      <!-- SERVIÇO -->
      <div class="services">
        <h3>Reparos necessários</h3>
        <div class="form-control">
          <label for="changes">Peças a serem substituídas</label>
          <textarea name="changes" id="changes" rows="7"></textarea>
        </div>
        <div class="row">
          <div class="form-control">
            <label for="price">preço do serviço</label>
            <input type="text" name="price" id="price">
          </div>
          <div class="form-control">
            <label for="service_date">Data do serviço</label>
            <input type="text" name="service_date" id="service_date">
          </div>
        </div>
      </div>
      <div class="buttons-container">
        <button type="submit">Concluir cadastro</button>
        <a href="/">Cancelar</a>
      </div>
    </form>
  </main>
  
  <script>
    const fields = {
      name: 'alpha|min:1',
      phone: 'numeric|min:1|max:15',
      cpf: 'numeric|cpf|min:1|max:14',
      address: 'alphanumeric|min:1',
      brand: 'alpha|min:1',
      model: 'alphanumeric|min:1',
      year: 'numeric|min:1|max:4',
      plate: 'alphanumeric|min:1',
      color: 'alpha|min:1',
      km: 'numeric|min:1',
      fuel: 'numeric|min:1',
      reported_defect: 'optional|alphanumeric|max:500',
      problem_found: 'optional|alphanumeric|max:500',
    };
  </script>
  <script src="<?= assets('js/form.js') ?>"></script>
</body>
</html>
