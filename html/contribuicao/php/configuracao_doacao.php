
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
    </head>
    <script>
   		document.write('<a href="' + document.referrer + '"></a>');
    </script>
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
								<a href="../../../home.php">
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
								<a class="nav-link active" id="b_boleto" data-toggle="tab" href="#img-tab" role="tab" aria-controls="img" aria-selected="true">BOLETOFACIL</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="b_boleto2" data-toggle="tab" href="#txt-tab" role="tab" aria-controls="txt" aria-selected="false">WIDEPAY</a>
                            </li>
                            <li class="nav-item">
								<a class="nav-link active" id="b_cartao" data-toggle="tab" href="#img-tab" role="tab" aria-controls="img" aria-selected="false">PAGSEGURO</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="b_cartao2" data-toggle="tab" href="#txt-tab" role="tab" aria-controls="txt" aria-selected="false">PAYPAL</a>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent" width = "50%">
                            <div id='boleto'>
                                <form action="atualizacao_doacao.php" method = "POST">
                                <input type="hidden" id="cod_sistema" name="cod_sistema">
                                <div class="tab-pane active" id="img-tab" role="tabpanel" aria-labelledby="img-tab">
                                    <table class="table table-hover"  >
                                        <thead>
                                        <legend>Regras Para Doação</legend>
                                            <tr>
                                            <th scope="col" width="5%">Valor Mínimo Boleto Único</th>
                                            <th scope="col" width="5%">Valor Mínimo Doação Mensal</th>
                                            <th scope="col" width="5%">Valor Máximo Doação Mensal:</th>
                                            </tr>
                                            <tr id='preenche_bolr1'>
                                            <td><input type='text' name='minval' id='minval'></td>
                                            <td><input type='text' name='minvalparc' id='minvalparc'></td>
                                            <td><input type='text' name='maivalparc' id='maivalparc'></td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Pagamento Após vencimento Boleto Único:</th>
                                            <th scope="col">Pagamento Após Vencimento Doação Mensal:</th>
                                            <th scope="col">Juros:</th>
                                            </tr>
                                            <tr id='preenche_bolr2'>
                                            <td><input type='text' name='unicdiasv' id='unicdiasv'></td>
                                            <td><input type='text' name='mensaldiasv' id='mensaldiasv'></td>
                                            <td><input type='text' name='juros' id='juros'></td>
                                            </tr>
                                            <tr>
                                            <th>Multa:</th>
                                            <th>Agradecimentos</th>
                                            </tr>
                                            <tr id='preenche_bolr3'>
                                            <td><input type='text' name='multa' id='multa'></td>
                                            <td><input type='text' name='agradecimento' id='agrad'></td>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table class="table table-hover">
                                        <thead>
                                            <legend>Datas de Vencimento Para Boleto Mensal</legend>
                                            <tr>
                                                <th scope="col" width="5%">opção 1</th>
                                                <th scope="col" width="5%">opção 2</th>
                                                <th scope="col" width="5%">opcão 3</th>
                                            </tr>
                                            <tr id='preenche_bol2'>
                                                <td><input type='number' name='op1' value=></td>
                                                <td><input type='number' name='op2' value=></td>
                                                <td><input type='number' name='op3' value=></td>
                                            </tr>
                                            <tr>
                                                <th scope="col" width="5%">opção 4</th>
                                                <th scope="col" width="5%">opção 5</th>
                                                <th scope="col" width="5%">opção 6</th>
                                            </tr>
                                            
                                            <tr id='preenche_bol2.2'>
                                                <td><input type='number' name='op4' value=></td>
                                                <td><input type='number' name='op5' value=></td>
                                                <td><input type='number' name='op6' value=></td>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table class="table table-hover">
                                    <legend>Configuração de Sistema</legend>
                                            <tr>
                                                <th scope="col" width="5%">Link API</th>
                                                <th scope="col" width="5%">TOKEN API</th>
                                                <th scope="col" width="5%">Link SANDBOX</th>
                                            </tr>
                                            <tr id="info_bol">
                                                <td><input type='text' name='api' value=></td>
                                                <td><input type='text' name='token_api' value=></td>
                                                <td><input type='text' name='sandbox' value=></td>
                                            <tr>
                                                <th scope="col" width="5%">TOKEN SANDBOX</th>
                                            </tr>
                                            <tr id="info_bol2">
                                                <td><input type='text' name='token_sandbox' value=></td>
                                            </tr>
                                    </table>
                                </div>

                                </form>
                            </div>
                            <div id='cartao'>
                                <input type='hidden' name='cod_cartao'>
                                <table class="table table-hover">
                                    <legend>DOAÇÃO AVULSA</legend>
                                    <tr>
                                        <th scope="col" width="5%">LINK</th>
                                    </tr>
                                    <tr id='avulso_link'>
                                        <td><input type='text' name='avulso_link' value=></td>
                                    </tr>
                                </table>
                                <div id='doacao_mensal'>
                                </div>    
                            </div>   
                        </div>
						</div>
                    </div>
                </div>
			</section>
        </div>
            <!-- end: header -->
	</section>
	<script>
        $(document).ready(function() 
        {
            
            $("#header").load("../../header.php");
            $(".menuu").load("../../menu.html");
            var id = '';
            preencher(id);
            $("#cartao").hide();

            $("#b_cartao").click(function(){ 
                var id = 1;
                
                preenche_dados_cartao(id);
                $("#boleto").hide();
                $("#cartao").fadeIn();
            });
            $("#b_boleto").click(function(){
                var id = 3;
               
               preencher(id);
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
                
                preencher(id);
                $("#boleto").fadeIn();
                $("#cartao").hide();
            });
        });
	
    </script>
        
