<?php
  use function \Src\Helpers\assets;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: sans-serif;
      outline: none;
    }
    main {
      margin: 1rem;
      border: 1px solid #000;
      border-bottom: 0;
    }

    div.row {
      border-bottom: 1px solid #000;
      display: flex;
    }

    div.row.no-line {
      border-bottom: 0;
    }

    div.row > div {
      flex: 1;
    }

    div.padding {
      padding: .8rem 0;
    }

    div.border-left {
      border-left: 1px solid #000;
    }

    div.header > div {
      text-align: center;
      display: grid;
      place-items: center;
    }
    
    div.title {
      background-color: #000;
      color: #fff;
    }

    div.title h1 {
      text-shadow: 3px 3px 0	#4169E1;
    }

    div.title span {
      text-transform: uppercase;
      padding-top: .5rem;
    }

    div.order-info > div {
      position: relative;
      display: grid;
      place-items: center;
    }

    div.order-info > div > span:first-of-type {
      position: absolute;
      top: .5rem;
      left: .5rem;
      font-size: 1.4rem;
    }

    .bold {
      font-weight: bold;
    }
    
    div.order-info > div > span:last-of-type {
      font-size: 1.5rem;
    }

    div.section {
      padding: .2rem .5rem;
    }

    div.order-text > div {
      padding: .5rem;
      min-height: 180px;
    }

    div.order-text > div > span:first-of-type {
      display: block;
      font-size: 1.4rem;
      margin-bottom: .5rem;
    }
    div.order-text > div > span:last-of-type {
      font-size: 1.2rem;
      line-height: 1.5;
      padding-left: 1rem;
    }

    table {
      width: 100%;
      margin: .5rem;
      margin-bottom: 1rem;
    }

    td {
      text-align: center;
      padding: .5rem 0;
    }

    div.table-container {
      display: flex;
      flex-direction: column;
    }

    a {
      background-color: #000;
      display: block;
      height: 50px;
      width: 50px;
      display: grid;
      place-items: center;
      position: fixed;
      right: 1rem;
      bottom: 1rem;
    }

    table.amount {
      width: fit-content;
      justify-self: start;
    }

    table.amount td {
      padding: 0;
      font-size: 1.2rem;
      text-align: left;
      padding-right: 1rem;
    }
  </style>
</head>
<body>

  <main>
    <div class="row header">
      <div class="title padding">
        <h1>JRC</h1>
        <span>Serviços automotivos</span>
      </div>
      <div>
        <h3 style="font-size: 1.5rem;">Ordem de serviço</h3>
      </div>
    </div>

    <div class="row">
      <div style="display: grid; gap: .5rem; place-items: center;" class="padding">
        <span>Setor de Chácaras P Norte CH 86 CJ D, LT 15</span>
        <span>(61) 98256-6066</span>
        <span>CNPJ: 42.688.541/0001-02</span>
      </div>
      <div class="row no-line order-info">
        <div class="border-left">
          <span class="bold">Nº:</span>
          <span>55555</span>
        </div>
        <div class="border-left">
          <span class="bold">Data:</span>
          <span>00/00/2004</span>
        </div>
      </div>
    </div>

    <!-- DADOS DO CLIENTE -->
    <div class="row section">
      <h2>Dados do cliente</h2>
    </div>
    <div class="row" style="height: 95px;">
      <div class="row no-line order-info">
        <div>
          <span>Nome:</span>
          <span><?= $data->name ?></span>
        </div>
        <div class="border-left">
          <span>CPF:</span>
          <span><?= $data->cpf ?></span>
        </div>
      </div>
    </div>
    <div class="row" style="height: 95px;">
      <div class="row no-line order-info">
        <div>
          <span>Endereço:</span>
          <span><?= $data->address ?></span>
        </div>
        <div class="border-left">
          <span>Telefone:</span>
          <span><?= $data->phone ?></span>
        </div>
      </div>
    </div>

    <!-- DADOS DO VEÍCULO -->
    <div class="row section">
      <h2>Dados do veículo</h2>
    </div>
    <div class="row" style="height: 95px;">
      <div class="row no-line order-info">
        <div>
          <span>Placa:</span>
          <span><?= $data->car->plate ?></span>
        </div>
        <div class="border-left">
          <span>Marca:</span>
          <span><?= $data->car->brand ?></span>
        </div>
        <div class="border-left">
          <span>Modelo:</span>
          <span><?= $data->car->model ?></span>
        </div>
        <div class="border-left">
          <span>Cor:</span>
          <span><?= $data->car->color ?></span>
        </div>
      </div>
    </div>
    <div class="row" style="height: 95px;">
      <div class="row no-line order-info">
        <div>
          <span>Ano:</span>
          <span><?= $data->car->year ?></span>
        </div>
        <div class="border-left">
          <span>KM atual:</span>
          <span><?= $data->car->km ?> KM</span>
        </div>
        <div class="border-left">
          <span>Combustível:</span>
          <span><?= $data->car->fuel ?> Litros</span>
        </div>
      </div>
    </div>
    <div class="order-text row">
      <div>
        <span class="bold">Problema informado:</span>
        <span><?= $data->car->reported_defect ?></span>
      </div>
    </div>
    <div class="order-text row">
      <div>
        <span class="bold">Problema constatado:</span>
        <span><?= $data->car->problem_found ?></span>
      </div>
    </div>

    <!-- DADOS DAS PEÇAS -->
    <div class="row section">
      <h2>Peças</h2>
    </div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Descrição do item</th>
            <th>Valor da unidade</th>
            <th>Quantidade</th>
            <th>Valor total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
        </tbody>
      </table>
      <div style="border-top: 1px solid #000; width: 100%; max-width: 400px; padding: .8rem; align-self: end;">
        <span class="bold">Total peças R$</span>
      </div>
    </div>

    <!-- DADOS DOS SERVIÇOS -->
    <div class="row section" style="border-top: 1px solid #000;">
      <h2>Serviços</h2>
    </div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Descrição do item</th>
            <th>Valor da unidade</th>
            <th>Quantidade</th>
            <th>Valor total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
          <tr>
            <td>Alguma peça legal ai</td>
            <td>R$25</td>
            <td>2</td>
            <td>R$ 50</td>
          </tr>
        </tbody>
      </table>
      <div style="border-top: 1px solid #000; width: 100%; max-width: 400px; padding: .8rem; align-self: end;">
        <span class="bold">Total peças R$</span>

      </div>
    </div>
    <div class="row no-line">
      <div class="row" style="border-top: 1px solid #000;">
        <div class="row no-line order-info">
          <div style="display: block;">
            <span class="bold">De acordo:</span>
            <div class="bold" style="text-align: center; border-top: 1px solid #000; position: absolute; left: 0; bottom: 0; right: 0; padding: .5rem 0;">
              Assinatura do cliente
            </div>
          </div>
          <div class="border-left">
            <table class="amount">
              <tbody>
                <tr>
                  <td>Valor peças:</td>
                  <td>25.00</td>
                </tr>
                <tr>
                  <td>Valor serviços:</td>
                  <td>25.00</td>
                </tr>
                <tr>
                  <td>Valor descontos:</td>
                  <td>25.00</td>
                </tr>
                <tr>
                  <td>Valor total:</td>
                  <td>25.00</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
  </main>
  
  <a href="/">
    <img src="<?= assets('images/home.svg') ?>" alt="go to home">
  </a>
</body>
</html>
