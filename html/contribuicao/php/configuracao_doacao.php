<?php

$config_path = "config.php";
if(file_exists($config_path)){
    require_once($config_path);
}else{
    while(true){
        $config_path = "../" . $config_path;
        if(file_exists($config_path)) break;
    }
    require_once($config_path);
}
session_start();
if(!isset($_SESSION['usuario'])){
    header ("Location: ".WWW."html/index.php");
}
// Adiciona a Função display_campo($nome_campo, $tipo_campo)
require_once ROOT."/html/personalizacao_display.php";
?>

<!DOCTYPE html>
    <html>
        <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>/assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="<?php echo WWW;?>assets/vendor/modernizr/modernizr.js"></script>
        
    <!-- Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        
    <!-- Specific Page Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        
    <!-- Theme Base, Components and Settings -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
        
    <!-- Theme Custom -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
    <!-- Theme Initialization Files -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>


    <!-- javascript functions -->
    <script src="<?php echo WWW;?>Functions/onlyNumbers.js"></script>
    <script src="<?php echo WWW;?>Functions/onlyChars.js"></script>
    <script src="<?php echo WWW;?>Functions/mascara.js"></script>
        
    <!-- jquery functions -->

            <title> Configuração Contribuição</title>
            <meta charset = "utf-8">
            <link rel="stylesheet" type="text/css" href="../outros/css/configuracao.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script type="text/javascript" src="../js/preenche_dados.js"></script>
        </head>
        <script>
        $(function(){$("#header").load("<?php echo WWW;?>html/header.php");
        $(".menuu").load("<?php echo WWW;?>html/menu.php");}); </script>
       
        <body>
        <div id = "header"></div>
                <form>
                    <ul class="nav">
                        <li><a id='b_boleto'>BOLETOFACIL</a></li>
                        <li><a id='b_boleto2'>WIDEPAY</a></li>
                        <li><a id='b_cartao'>PAGSEGURO</a></li>
                        <li><a id='b_cartao2'>PAYPAL</a></li>
                    </ul>
                </form>
                <br><br><br>
            <form action="atualizacao_doacao.php" method = "POST">
                <div id='boleto'>   
                    <table border = '1px'>
                    <input type='hidden' id='cod_sistema' name='cod_sistema'>
                    <h3>REGRAS PARA DOAÇÃO</h3>
                        <tr>
                            <th>Valor Mínino Boleto Único:</th>
                            <th>Valor Mínino Doação Mensal:</th>
                            <th>Valor Máximo Doação Mensal:</th>
                            <th>Pagamento Após vencimento Boleto Único:</th>
                            <th>Pagamento Após Vencimento Doação Mensal:</th>
                            <th>Juros:</th>
                            <th>Multa:</th>
                            <th>Agradecimentos</th>
                        </tr>
                        <tr id='preenche_bolr'>
                        <td><input type='text' name='minval' id='minval'></td>
                        <td><input type='text' name='minvalparc' id='minvalparc'></td>
                        <td><input type='text' name='maivalparc' id='maivalparc'></td>
                        <td><input type='text' name='unicdiasv' id='unicdiasv'></td>
                        <td><input type='text' name='mensaldiasv' id='mensaldiasv'></td>
                        <td><input type='text' name='juros' id='juros'></td>
                        <td><input type='text' name='multa' id='multa'></td>
                        <td><input type='text' name='agradecimento' id='agrad'></td>
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
                    </table>
                </div>
                <div id='cartao'>
                    <input type='hidden' name='cod_cartao'>
                    <table border = '1px'>
                        <h3>DOAÇÃO AVULSA</h3>
                        <tr>
                            <th>LINK</th>
                        </tr>
                        <tr id='avulso_link'>
                            <td><input type='text' name='avulso_link' value=></td>
                        </tr>
                    </table>
                    <div id='doacao_mensal'>
                        
                    </div>
                        
                </div>
                <br><input type='submit' value='atualizar'>
            </form>
    <script>
        $(document).ready(function(){
            $("#header").load("../header.php");
            $(".menuu").load("../menu.html");
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
                
