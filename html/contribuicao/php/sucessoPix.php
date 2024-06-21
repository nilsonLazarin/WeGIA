<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        body{
            background-color: gainsboro;
            font-family: Arial, Helvetica, sans-serif;
            font-size: medium;
        }
        .success-message {
            width: 300px;
            height: 200px;
            border: 1px solid #E0E0E0;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
            margin-top: 150px;
}
        

            .checkmark-circle {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background-color: #4CAF50;
                display: flex;
                justify-content: center; 
                align-items: center;
            }

            .checkmark {
                color: white;
                font-size: 24px;
            }


        .success-text {
            color: black; 
            font-size: 16px;
            margin-top: 16px;
        }

        .inicial-pag-btn{
            margin-top: 50px;
            padding: 10px;
            border: none;
            border-radius: 3px;
            background-color: #007BFF ;
        }

        .inicial-pag-btn:hover{
            transition: all 0.4s ease-out ;
            background-color: #0559b3;
        }

        .inicial-pag-link{
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="success-message">
        <div class="checkmark-circle">
            <span class="checkmark">✓</span>
        </div>
        <p class="success-text">Doação realizada com sucesso!</p>
        <button class="inicial-pag-btn"><a href="./configuracao_doacao.php" class="inicial-pag-link">VOLTAR PARA A PÁGINA DE DOAÇÕES</a></button>
    </div>
</body>
</html>
