<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../../../index.php");
    }
?>
<!DOCTYPE html>
<html class="fixed">
    <head>
        <meta charset="UTF-8">
        <title>Configuração Contribuição</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="../../../assets/vendor/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link rel="stylesheet" href="../../../assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="../../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
        <link rel="stylesheet" href="../../../assets/stylesheets/theme.css" />
        <link rel="stylesheet" href="../../../assets/stylesheets/skins/default.css" />
        <link rel="stylesheet" href="../../../assets/stylesheets/theme-custom.css">
        <script src="../../../assets/vendor/modernizr/modernizr.js"></script>
        <link rel="stylesheet" href="../../../css/personalizacao-theme.css" />
        <script src="../../../assets/vendor/jquery/jquery.min.js"></script>
        <script src="../../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
        <script src="../../../assets/vendor/bootstrap/js/bootstrap.js"></script>
        <script src="../../../assets/vendor/nanoscroller/nanoscroller.js"></script>
        <script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="../../../assets/vendor/magnific-popup/magnific-popup.js"></script>
        <script src="../../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        <script src="../../../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        <script src="../../../assets/javascripts/theme.js"></script>
        <script src="../../../assets/javascripts/theme.custom.js"></script>  
        <script src="../../../assets/javascripts/theme.init.js"></script>
        <script type="text/javascript" src="preenche_dados.js"></script>
        <script type="text/javascript" src="id_sistema.js"></script>

    </head>
    <style> 
        #vazio
        {
            color: red;
			font-size: 20px;
			font-family: 'Bitter', serif;
        } 
        #vazio_cartao_unico{
            color: red;
			font-size: 15px;
			font-family: 'Bitter', serif;
        }
        #vazio_cartao_mensal{
            color: red;
			font-size: 15px;
			font-family: 'Bitter', serif;
        }
    </style>
    <body>
	<section class="body">
		<div id="header"></div>
        <div class="inner-wrapper">
			<!-- start: sidebar -->
			<aside id="sidebar-left" class="sidebar-left menuu"></aside>
			<!-- end: sidebar -->
			<section role="main" class="content-body">
				<header class="page-header">
					<h2>Configuração de Contribuição</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="../../home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Páginas</span></li>
							<li><span>Configuração Contribuição</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
                </header>
                <div class="row">
					<div class="col-md-4 col-lg-2"></div>
					<div class="col-md-8 col-lg-8">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item active">
								<a class="nav-link active" id="boletofacil" data-toggle="tab" href="#img-tab" role="tab" aria-controls="img" aria-selected="true">BOLETOFACIL</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="widepay" data-toggle="tab" href="#txt-tab" role="tab" aria-controls="txt" aria-selected="false">WIDEPAY</a>
                            </li>
                            <li class="nav-item">
								<a class="nav-link active" id="pagseguro" data-toggle="tab" href="#img-tab" role="tab" aria-controls="img" aria-selected="false">PAGSEGURO</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="paypal" data-toggle="tab" href="#txt-tab" role="tab" aria-controls="txt" aria-selected="false">PAYPAL</a>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent" width = "50%"> 
                           
                        <div id='boleto'> 
                            <form action="atualizacao_doacao.php" method = "POST" id="form1">
                                <input type="hidden" id="regras_sistema" name="regras_sistema">
                                <input type='hidden' id='id_sistema' name='id_sistema'>
                                <span id="vazio"></span>
                                <div class="tab-pane active" id="img-tab" role="tabpanel" aria-labelledby="img-tab">
                                    <table class="table table-bordered mb-none">
                                    <!--table class="table table-hover"-->
                                        <!--thead-->
                                        <h3>Regras Para Doação</h3>
                                        <br>
                                            <tr style= "width: 50px;">
                                                <th scope="col" width="5%">Valor Mínimo Boleto Único</th>
                                                <th scope="col" width="5%">Valor Mínimo Doação Mensal</th>
                                                <th scope="col" width="5%">Valor Máximo Doação Mensal:</th>
                                            </tr>
                                            <tr id='preenche_bolr1' style= "width: 50px;">
                                            <td><input id='minval' class="form-control" type='number'  name='minval' autocomplete="on" size="10"></td>
                                            <td><input type='number' class="form-control" name='minvalparc' id='minvalparc'></td>
                                            <td><input type='number' class="form-control"name='maivalparc' id='maivalparc'></td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Pagamento Após vencimento Boleto Único:</th>
                                            <th scope="col">Pagamento Após Vencimento Doação Mensal:</th>
                                            <th scope="col">Juros:</th>
                                            </tr>
                                            <tr id='preenche_bolr2'>
                                            <td><input type='text' class="form-control" name='unicdiasv' id='unicdiasv'></td>
                                            <td><input type='text' class="form-control" name='mensaldiasv' id='mensaldiasv'></td>
                                            <td><input type='text' class="form-control" name='juros' id='juros'></td>
                                            </tr>
                                            <tr>
                                            <th>Multa:</th>
                                            <th>Agradecimentos</th>
                                            </tr>
                                            <tr id='preenche_bolr3'>
                                            <td><input type='text' class="form-control" name='multa' id='multa'></td>
                                            <td><textarea name='agradecimento' class="form-control" cols='18'  id='agrad'></textarea></td>
                                            </tr>
                                        <thead>
                                    </table>
                                    <!--table class="table table-hover"-->
                                    <table class="table table-bordered mb-none">
                                        <thead>
                                            <h3>Datas de Vencimento Para Boleto Mensal</h3>
                                            <br>
                                            <tr>
                                                <th scope="col" width="5%">opção 1</th>
                                                <th scope="col" width="5%">opção 2</th>
                                                <th scope="col" width="5%">opcão 3</th>
                                            </tr>
                                            <tr id='preenche_bol1'>
                                                <td><input type='number' class="form-control" name='op01' value=></td>
                                                <td><input type='number' class="form-control" name='op02' value=></td>
                                                <td><input type='number' class="form-control" name='op03' value=></td>
                                            </tr>
                                            <tr>
                                                <th scope="col" width="5%">opção 4</th>
                                                <th scope="col" width="5%">opção 5</th>
                                                <th scope="col" width="5%">opção 6</th>
                                            </tr>
                                            <tr id='preenche_bol2'>
                                                <td><input type='number' class="form-control" name='op04' value=></td>
                                                <td><input type='number' class="form-control" name='op05' value=></td>
                                                <td><input type='number' class="form-control" name='op06' value=></td>
                                            </tr>
                                        </thead>
                                    </table>
                                    <!--table class="table table-hover"-->
                                    <table class="table table-bordered mb-none">
                                    <h3>Configuração de Sistema</h3>
                                    <br>
                                            <tr>
                                                <th scope="col" width="5%">Link API</th>
                                                <th scope="col" width="5%">TOKEN API</th>
                                                <th scope="col" width="5%">Link SANDBOX</th>
                                            </tr>
                                            <tr id="info_bol3">
                                                <td><input type='text' class="form-control" name='api' value=></td>
                                                <td><input type='text' class="form-control" name='token_api' value=></td>
                                                <td><input type='text' class="form-control" name='sandbox' value=></td>
                                            <tr>
                                                <th scope="col" width="5%">TOKEN SANDBOX</th>
                                            </tr>
                                            <tr id="info_bol4">
                                                <td><input type='text' class="form-control" name='token_sandbox' value=></td>
                                            </tr>
                                    </table>
                                <input type="submit" class= "btn btn-primary" id="btn" value="Editar Informações">
                                <a href="../index.php"><input type="button" class="btn btn-primary" value="Ir à Página de Contribuição"></a>
                                </div>
                                
                            </form>
                        </div>
                                
                        <div id='cartao'>
                            <form action="atualizacao_doacao.php" method='POST' id="form2">
                                <div class="tab-pane active" id="img-tab" role="tabpanel" aria-labelledby="img-tab">
                                    <input type='hidden' name='cod_cartao' id='cod_cartao'>
                                    <span id='vazio_cartao_unico'></span>
                                    <!--table class="table table-hover"-->
                                    <table class="table table-bordered mb-none">
                                        <h3>DOAÇÃO AVULSA</h3>
                                        <br>
                                        <tr>
                                            <th>LINK</th>
                                        </tr>
                                        <tr id='avulso_link'>
                                            <td><input type='text' class="form-control" name='avulso_link' value=></td>
                                        </tr>
                                    </table>
                                    <span id='vazio_cartao_mensal'></span>
                                    <h3>DOAÇÃO MENSAL</h3>
                                    <br>
                                    <div id='doacao_mensal'>
                                    </div> 
                                    <div id = 'insere_doacao_mensal'>
                                        <!--table-->
                                        <table class="table table-bordered mb-none">
                                            <tr>
                                                <th>VALOR</th><th>LINK</th>
                                            </tr>
                                            <tr>
                                                <td><input type='number' class="form-control" name='valor[0]' value =></td>
                                                <td><input type='text' class="form-control" name='mensal_link[0]' value=></td>
                                            </tr>
                                            <tr>
                                                <td><input type='number' class="form-control" name='valor[1]' value =></td><td><input type='text' class="form-control" name='mensal_link[1]' value=></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br><br>
                                    <input type="submit" class= "btn btn-primary" id="btn" value="Editar Informações">
                                    <a href="../index.php"><input type="button" class="btn btn-primary" value="Ir à Página de Contribuição"></a>  
                                </div> 
                            </form>
						</div>
                    </div>
                </div>
			</section>
        </div>
	</section>
	<script>
        $(document).ready(function() 
        {
            var id = retorna_id("boletofacil");
            $("#header").load("../../header.php");
            $(".menuu").load("menu.html");
            $("#cartao").hide();
            $("#insere_doacao_mensal").hide();

            $("#pagseguro").click(function(){ 
                
                var id = retorna_id('pagseguro');
                $("#boleto").hide();
                $("#cartao").fadeIn();
            });
            $("#boletofacil").click(function(){
               
               var id = retorna_id("boletofacil");
                $("#boleto").fadeIn();
                $("#cartao").hide();
            });
            $("#paypal").click(function(){ 

                var id = retorna_id("paypal");
                $("#boleto").hide();
                $("#cartao").fadeIn();
            });
            $("#widepay").click(function(){
                
                var id = retorna_id("widepay");
                $("#boleto").fadeIn();
                $("#cartao").hide();
            });
        });
	
    </script>
        
