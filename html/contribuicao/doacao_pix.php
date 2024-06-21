<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        padding: 20px;
    }

    .container-formulario {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 0 auto;
    }

    .h1-formulario {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .label-formulario {
        display: block;
        margin-bottom: 5px;
    }

    .input-formulario {
        width: 95%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .button-formulario {
        background-color: #007BFF;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .button-formulario:hover {
        background-color: #0056b3;
    }
    </style>
    <title>Pagamento PIX</title>
</head>
<body>
    <div class="container-formulario">
        <h1 class="h1-formulario" >Formulário de Pagamento PIX</h1>
        <form action="../contribuicao/php/pixPagamento.php" id="formulario" method="POST">
            <div class="form-group">
                <label class="label-formulario" for="name">Nome:</label>
                <input class="input-formulario" type="text" id="name" name="name" placeholder="Ex: João da Silva" required>
            </div>
            <div class="form-group">
                <label class="label-formulario" for="email">E-mail:</label>
                <input class="input-formulario" type="email" id="email" name="email" placeholder="Ex: joao@exemplo.com" required>
            </div>
            <div class="form-group">
                <label class="label-formulario" for="document">CPF:</label>
                <input class="input-formulario" type="number" id="document" name="document" placeholder="CPF: 123.456.789-10" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" required>
            </div>            
            <div class="form-group">
                <label class="label-formulario" for="phone">Telefone:</label>
                <input class="input-formulario" type="number" id="phone" name="phone" placeholder="(11) 91234-5678" pattern="\(\d{2}\) \d{5}-\d{4}" required>
            </div>
            <div class="form-group">
                <label class="label-formulario" for="amount">Valor (R$):</label>
                <input class="input-formulario" type="number" step="0.01" id="amount" name="amount" placeholder="Ex: 100.00" required>
            </div>
            <div class="form-group">
                <button class="button-formulario" type="submit">Realizar Pagamento</button>
            </div>
        </form>
    </div>
</body>
</html>

