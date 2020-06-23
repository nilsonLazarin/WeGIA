<?php

    include("./contribuicao/php/conexao.php");

    //Query das informações do banco//

    //$SISTEMA = $_POST['id_sistema'];
    $QUERYSYSTEM  = mysqli_query($conexao, "SELECT * FROM  sistema_pagamento WHERE id = 3");
    $REGISTRO = mysqli_fetch_row($QUERYSYSTEM);
    $nome_sistema = $REGISTRO[1];

    $QUERYR  = mysqli_query($conexao, "SELECT * FROM doacao_boleto_regras as regras JOIN doacao_boleto_info as info ON (info.id_regras = regras.id) WHERE info.id_sistema = 3");
    $REGRAS = mysqli_fetch_row($QUERYR);
    
    $MinValUnic = $REGRAS[1];
    $MensalDiasV = $REGRAS[2];
    $juros = $REGRAS[3];
    $multa = $REGRAS[4];
    $MaiValParc = $REGRAS[5];
    $MinValParc = $REGRAS[6];
    $agradecimento = $REGRAS[7];
    $UnicDiasV = $REGRAS[8];
    $opVenc[0] = $REGRAS[9];
    $opVenc[1] = $REGRAS[10];
    $opVenc[2] = $REGRAS[11];
    $opVenc[3] = $REGRAS[12];
    $opVenc[4] = $REGRAS[13];
    $opVenc[5] = $REGRAS[14];
    $API = $REGRAS[16];
    $token = $REGRAS[17];

    $QUERYS = mysqli_query($conexao, "SELECT * FROM sistema_pagamento");
    $SISTEMAS = mysqli_fetch_row($QUERYS);

?>
    <!DOCTYPE html>
    <html>
        <head>
            <title> Configuração Contribuição</title>
            <meta charset = "utf-8">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        </head>
        <body>
            <form action = "atualizacao_doacao.php" method = "POST">
                <h3>DOAÇÕES SISTEMA <?php echo $nome_sistema ?></h3>

                <fieldset>
                    <legend> REGRAS PARA DOAÇÃO</legend>
                    <table border = '1px'>
                    <tr>
                        <td>Valor Mínino Boleto Único:</td>
                        <td>Valor Mínino Doação Mensal:</td>
                        <td>Valor Máximo Doação Mensal:</td>
                        <td>Pagamento Após vencimento Boleto Único:</td>
                        <td>Pagamento Após Vencimento Doação Mensal:</td>
                        <td>Juros:</td>
                        <td>Multa:</td>
                    </tr>
                    <tr>
                    <td><input type='text' name='minval' value='<?php echo $MinValUnic ?>'></td>
                    <td><input type='text' name='minvalparc' value='<?php echo $MinValParc ?>'></td>
                    <td><input type='text' name='maivalparc' value='<?php echo $MaiValParc ?>'></td>
                    <td><input type='text' name='unicdiasv' value='<?php echo $UnicDiasV ?>'></td>
                    <td><input type='text' name='mensaldiasv' value='<?php echo $MensalDiasV ?>'></td>
                    <td><input type='text' name='juros' value='<?php echo $juros ?>'></td>
                    <td><input type='text' name='multa' value='<?php echo $multa ?>'></td>
                </tr>
                </table>
                
                </fieldset>
                


            </form>
        </body>
    </html>


    
