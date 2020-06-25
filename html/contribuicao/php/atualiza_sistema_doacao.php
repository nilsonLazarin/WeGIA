<!DOCTYPE html>
    <html>
        <head>
            <title> Configuração Contribuição</title>
            <meta charset = "utf-8">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        </head>
        <body>
             
                <form action = 'seleciona_sistema.php' method='GET'>
                     DOAÇÕES SISTEMA <select>
                                <option value='3'name='sistema'>BOLETOFACIL</option>
                                <option value='4'name='sistema'>WIDEPAY</option>
                                <option value='1'name='sistema'>PAGSEGURO</option>
                                <option value='2'name='sistema'>PAYPAL</option>
                                </select><input type='submit' value='selecionar sistema'>
                </form>
                <br>

<?php

    include("conexao.php");
    
    //Query das informações do banco//
    //header("Location: seleciona_sistema.php")
    
    //$ID_SISTEMA = $_GET['id_sistema'];

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
    $sandbox = $REGRAS[18];
    $token_sandbox = $REGRAS[19];

    $QUERYS = mysqli_query($conexao, "SELECT url FROM doacao_cartao_avulso WHERE id_sistema= 2");
    $LINK_PAYPAL = mysqli_fetch_row($QUERYS);
    $paypal = $LINK_PAYPAL[0];

    $QUERYS_PAG = mysqli_query($conexao, "SELECT url FROM doacao_cartao_avulso WHERE id_sistema= 1");
    $LINK_PAG = mysqli_fetch_row($QUERYS_PAG);
    $pagseguro = $LINK_PAG[0];

    $DOACAO_30 = mysqli_query($conexao, "SELECT link FROM doacao_cartao_mensal WHERE valor = '30.00'");
    $REGISTROC = mysqli_fetch_row($DOACAO_30);
    $trinta = $REGISTROC[0];

    $DOACAO_40 = mysqli_query($conexao, "SELECT link FROM doacao_cartao_mensal WHERE valor = '40.00'");
    $REGISTROC = mysqli_fetch_row($DOACAO_40);
    $quarenta = $REGISTROC[0];

    $DOACAO_50 = mysqli_query($conexao, "SELECT link FROM doacao_cartao_mensal WHERE valor = '50.00'");
    $REGISTROC = mysqli_fetch_row($DOACAO_50);
    $cinquenta = $REGISTROC[0];

    $DOACAO_100 = mysqli_query($conexao, "SELECT link FROM doacao_cartao_mensal WHERE valor = '100.00'");
    $REGISTROC = mysqli_fetch_row($DOACAO_100);
    $cem = $REGISTROC[0];

?>
      
                <legend> REGRAS PARA DOAÇÃO</legend>

                <form action = "atualizacao_doacao.php" method = "POST" id="form_boletofacil">    
                <table border = '1px'>
                    <tr>
                        <th>Valor Mínino Boleto Único:</th>
                        <th>Valor Mínino Doação Mensal:</th>
                        <th>Valor Máximo Doação Mensal:</th>
                        <th>Pagamento Após vencimento Boleto Único:</th>
                        <th>Pagamento Após Vencimento Doação Mensal:</th>
                        <th>Juros:</th>
                        <th>Multa:</th>
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
                <br>
                <table border='1px'>
                    <legend>DATAS DE VENCIMENTO PARA BOLETO MENSAL</legend>
                    <tr>
                        <th>opção 1</th>
                        <th>opção 2</th>
                        <th>opcão 3</th>
                        <th>opção 4</th>
                        <th>opção 5</th>
                        <th>opção 6</th>
                    </tr>
                    <tr>
                        <td><input type='number' name='op1' value='<?php echo $opVenc[0]?>'></td>
                        <td><input type='number' name='op2' value='<?php echo $opVenc[1]?>'></td>
                        <td><input type='number' name='op3' value='<?php echo $opVenc[2]?>'></td>
                        <td><input type='number' name='op4' value='<?php echo $opVenc[3]?>'></td>
                        <td><input type='number' name='op5' value='<?php echo $opVenc[4]?>'></td>
                        <td><input type='number' name='op6' value='<?php echo $opVenc[5]?>'></td>
                    </tr>
                </table>
                <br>
                <table border='1px'>
                    <legend>CONFIGURAÇÕES DE SISTEMA</legend>
                    <tr>
                        <th>Link API</th>
                        <th>TOKEN API</th>
                        <th>Link SANDBOX</th>
                        <th>TOKEN SANDBOX</th>
                    </tr>
                    <tr>
                        <td><input type='text' name='api' value='<?php echo $API ?>'></td>
                        <td><input type='text' name='token_api' value='<?php echo $token ?>'></td>
                        <td><input type='text' name='sandbox' value='<?php echo $sandbox ?>'></td>
                        <td><input type='text' name='token_sandbox' value='<?php echo $token_sandbox ?>'></td>
                    </tr>
                </table><br><br>
                <table border='1px'>
                    <legend>DOAÇÕES ÚNICAS VIA CARTÃO</legend>
                    <br>
                    <tr> 
                        <th>Link PAGSEGURO</th>
                        <th>Link PAYPAL</th>
                    </tr>
                    <tr>
                        <td><input type='text' name='pagseguro' value='<?php echo $pagseguro?>'></td>
                        <td><input type='text' name='paypal' value='<?php echo $paypal ?>'></td>
                    </tr>   
                </table>
                <br>
                <table border='1px'>
                    <p>DOAÇÃO MENSAL VIA CARTÃO - SISTEMA PAGSEGURO</p>
                    <tr>
                        <th><input type='text' name='valor1' value='30.00'></th>
                        <th><input type='text' name='valor2' value='40.00'></th>
                        <th><input type='text' name='valor3' value='50.00'></th>
                        <th><input type='text' name='valor4' value='100.00'></th>
                    </tr>
                    <tr>
                        <td><input type='text' name='trinta' value='<?php echo $trinta ?>'></td>
                        <td><input type='text' name='quarenta' value='<?php echo $quarenta ?>'></td>
                        <td><input type='text' name='cinquenta' value='<?php echo $cinquenta ?>'></td>
                        <td><input type='text' name='cem' value='<?php echo $cem ?>'></td>
                    </tr>
                    
                </table>
            
            </form>
        </body>

    </html>


    
