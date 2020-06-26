<!DOCTYPE html>
    <html>
        <head>
            <title> Configuração Contribuição</title>
            <meta charset = "utf-8">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script type="text/javascript" src="../js/preenche_dados.js"></script>
        </head>
        <style>
       ul.nav { 
            margin:0; 
            padding:0;
            }
            
        ul.nav li {
            list-style:none;	
            display:inline;
            }
        ul.nav li a {
            float:left;
            border-top:0.1em solid #fff;
            border-right:0.1em solid #909090;
            border-bottom:0.1em solid #909090;
            border-left:0.1em solid #fff;
            width:7em;
            font:1em  Verdana, Arial, Helvetica, 
            sans-serif;
            background:#f1f1f1;
            color:#333;
            text-align:center;
            padding:0  0.2em 0.2em  0;
            text-decoration:none;
            }
        ul.nav a:hover{
            background:#999;
            color:#fff;
            border-color:#000 #fafafa #fafafa #000;
            }
      
        </style>
        <body>
                <form>
                    <ul class="nav">
                        <li><a id='b_boleto'>BOLETOFACIL</a></li>
                        <li><a id='b_boleto2'>WIDEPAY</a></li>
                        <li><a id='b_cartao'>PAGSEGURO</a></li>
                        <li><a id='b_cartao2'>PAYPAL</a></li>
                    </ul>
                </form>
                <br><br><br>
                <form action = "atualizacao_doacao.php" method = "POST">
                <div id='boleto'>   
                    <table border = '1px'>
                    <h3>REGRAS PARA DOAÇÃO</h3>
                        <tr>
                            <th>Valor Mínino Boleto Único:</th>
                            <th>Valor Mínino Doação Mensal:</th>
                            <th>Valor Máximo Doação Mensal:</th>
                            <th>Pagamento Após vencimento Boleto Único:</th>
                            <th>Pagamento Após Vencimento Doação Mensal:</th>
                            <th>Juros:</th>
                            <th>Multa:</th>
                        </tr>
                        <tr id='preenche_bolr'>
                        <td><input type='text' name='minval' id='minval'></td>
                        <td><input type='text' name='minvalparc' id='minvalparc'></td>
                        <td><input type='text' name='maivalparc' id='maivalparc'></td>
                        <td><input type='text' name='unicdiasv' id='unicdiasv'></td>
                        <td><input type='text' name='mensaldiasv' id='mensaldiasv'></td>
                        <td><input type='text' name='juros' id='juros'></td>
                        <td><input type='text' name='multa' id='multa'></td>
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
                        <tr id='preenche_bol2'>
                            <td><input type='number' name='op1' value=></td>
                            <td><input type='number' name='op2' value=></td>
                            <td><input type='number' name='op3' value=></td>
                            <td><input type='number' name='op4' value=></td>
                            <td><input type='number' name='op5' value=></td>
                            <td><input type='number' name='op6' value=></td>
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
                        <tr id="info_bol">
                            <td><input type='text' name='api' value=></td>
                            <td><input type='text' name='token_api' value=></td>
                            <td><input type='text' name='sandbox' value=></td>
                            <td><input type='text' name='token_sandbox' value=></td>
                        </tr>
                    </table><br><br>
                </div>
                <div id='cartao'>
                    <table border = '1px'>
                        <h3>DOAÇÃO AVULSA</h3>
                        <tr>
                            <th>LINK</th>
                        </tr>
                        <tr id='avulso_link'>
                            <td><input type='text' name='avulso_link' value=></td>
                        </tr>
                    </table>
                    <table border='1px'>
                        <h3>DOAÇÃO MENSAL</h3>
                        <tr>
                            <th>VALOR</th>
                            <th>LINK</th>
                        </tr>
                        <tr id='doacao_mensal'>
                            <td><input type='number' name='valor1' value=></td>
                        </tr>
                    </table>
                </div>

    <script>
        $(document).ready(function(){
            var id = '';
            preenche_dados(id);
            $("#cartao").hide();

            $("#b_cartao").click(function(){ 
                var id = 1;
                preenche_dados_cartao(id);
                $("#boleto").hide();
                $("#cartao").fadeIn();
            });
            $("#b_boleto").click(function(){
                var id = 3;
                preenche_dados(id);
                $("#boleto").fadeIn();
                $("#cartao").hide();
            });
            $("#b_cartao2").click(function(){ 

                var id = 2;
                preenche_dados_cartao(id);
                $("#boleto").hide();
                $("#cartao").fadeIn();
            });
            $("#b_boleto2").click(function(){
                
                var id = 4;
                preenche_dados(id);
                $("#boleto").fadeIn();
                $("#cartao").hide();
            });
        });
    </script>
                