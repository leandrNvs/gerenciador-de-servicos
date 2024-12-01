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
  <link rel="stylesheet" href="<?= htmlspecialchars(assets('css/form.css')) ?>">
</head>
<body>

  <main>
    <div class="links">
      <a href="/">Página inicial</a>
      >
      <a href="/cliente" style="color: dodgerblue;">Cadastrar novo serviço</a>
    </div>
    <form action="/cliente" method="POST" autocomplete="off">
      <div class="clients">
        <h3>Dados do cliente</h3>
        <div class="row">
          <div class="form-control">
            <label for="client">cliente</label>
            <input type="text" name="client" id="client" autofocus>
          </div>

          <div class="form-control">
            <label for="contact">contato</label>
            <input type="text" name="contact" id="contatc">
          </div>
        </div>
        <div class="row">
          <div class="form-control">
            <label for="client">CPF</label>
            <input type="text" name="client" id="client" autofocus>
          </div>

          <div class="form-control">
            <label for="contact">Endereço</label>
            <input type="text" name="contact" id="contatc">
          </div>
        </div>
      </div>
      <div class="cars">
        <h3>Dados do veículo</h3>
        <div class="row">
          <div class="form-control">
            <label for="brand">marca</label>
            <input type="text" name="brand" id="brand">
          </div>
          <div class="form-control">
            <label for="model">modelo</label>
            <input type="text" name="model" id="model">
          </div>
        </div>
        <div class="row">
          <div class="form-control">
            <label for="year">ano</label>
            <input type="text" name="year" id="year">
          </div>
          <div class="form-control">
            <label for="plate">placa</label>
            <input type="text" name="plate" id="plate">
          </div>
        </div>
        <div class="row">
          <div class="form-control">
            <label for="client">Cor</label>
            <input type="text" name="client" id="client" autofocus>
          </div>

          <div class="form-control">
            <label for="contact">KM atual</label>
            <input type="text" name="contact" id="contatc">
          </div>

          <div class="form-control">
            <label for="contact">Combustível</label>
            <input type="text" name="contact" id="contatc">
          </div>
        </div>
        <div class="form-control">
          <label for="problem">Defeito informado</label>
          <textarea name="problem" id="problem" rows="7"></textarea>
        </div>
        <div class="form-control">
          <label for="problem">Defeito constatado</label>
          <textarea name="problem" id="problem" rows="7"></textarea>
        </div>
      </div>
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
        <a href="/">Cancelar</button>
      </div>
    </form>
  </main>
  
  <script src="<?= htmlspecialchars(assets('js/form.js')) ?>"></script>
</body>
</html>
