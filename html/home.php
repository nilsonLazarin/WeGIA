<?php
	require_once "./seguranca/sessionStart.php";
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}

	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "personalizacao_display.php";

	// Funções de display de mensagens
	require_once "./geral/msg.php";
?>
<!doctype html>
<html class="fixed">
<head>

	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Home</title>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

	<!--Página Css que não interfere no estilo de oputras páginas do sistema-->
	<link rel="stylesheet" href="../css/home-theme.css" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="../assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="../assets/vendor/morris/morris.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
	<link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon">

	<!-- Skin CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="../assets/vendor/modernizr/modernizr.js"></script>
	<script src="../Functions/lista.js"></script>
	<!-- Vendor -->
	<script src="../assets/vendor/jquery/jquery.min.js"></script>

	<script type="text/javascript">
		$(function () {
	      $("#header").load("header.php");
	      $(".menuu").load("menu.php");
	    });	
	</script>
	<script>

		var itemState = {}

		function getState(id){
			let state = itemState[id];
			if (state)
				return state;
			return false;
		}

		function setState(id, state){
			itemState[id] = state;
		}

		function openItem(id){
			console.log(id, !getState(id));
			if (!getState(id)){
				$('html, body').animate({
					scrollTop: $(id).height()
				}, 2);
				setState(id, true);
			}else{
				setState(id, false);
			}
		}
    </script>

</head>
<body>
	<section class="body">
		<div id="header"></div>
	        <!-- end: header -->
	        <div class="inner-wrapper">
	            <!-- start: sidebar -->
	            <aside id="sidebar-left" class="sidebar-left menuu"></aside>
				<!-- end: sidebar -->

			<section role="main" class="content-body">
				<header class="page-header">
					<h2>Home</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="./home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Início</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!-- start: page -->
				<div class="row" >

				<!-- Recebe mensagem se houver -->
				<?php displayMsg(); sessionMsg();?>

				<?php
					if(isset($_GET['msg_c'])){
						$msg = $_GET['msg_c'];
						echo('<div class="alert alert-danger alerta_c" role="alert">
						'. $msg .'
					  </div>');
					}
				?>
					<a href="">
						<div class="col-lg-2 col-md-8 i" data-toggle="collapse" href="#pessoas" >
							<i  class="far fa-address-book"></i>
							<h4>Pessoas</h4>
						</div>
					</a>

					<a href="#">
						<div class="col-lg-2 col-md-8 i" data-toggle="collapse" href="#material">
							<i  class="fa fa-cubes"></i>
							<h4>Material e Patrimônio</h4>
						</div>
					</a>
					<!--onclick="window.location.href = '../memorando/envio.php'"-->
					<a href="#">
						<div class="col-lg-2 col-md-8 i" data-toggle="collapse" href="#memorando">
							<i  class="fa fa-book"></i>
							<h4>Memorando
							</h4>
						</div>
					</a>
					<a href="#">
						<div class="col-lg-2 col-md-8 i" data-toggle="collapse" href="#socios">
							<i  class="fa fa-users"></i>
							<h4>Sócios
							</h4>
						</div>
					</a>
					<a href="#">
						<div class="col-lg-2 col-md-8 i" data-toggle="collapse" href="#configuracao">
							<i  class="fa fa-cogs"></i>
							<h4>Configurações</h4>
						</div>
					</a>
					<a href="#">
					<div class="col-lg-2 col-md-8 i" data-toggle="collapse" href="#saude">
							<i  class="fa fa-ambulance"></i>
							<h4>Saúde</h4>
						</div>
					</a>

				</div>
				<hr class="mobile-only">
				<div class="row ">
					<div  id="configuracao" class="collapse">
						<a href="../html/personalizacao.php">
							<div class="col-lg-2 col-md-8 i" >
								<i  class="fa fa-font"></i>
								<h4>Editar conteúdos</h4>
							</div>
						</a>
						<a href="../html/personalizacao_imagem.php">
							<div class="col-lg-2 col-md-8 i" >
								<i  class="fa fa-picture-o"></i>
								<h4>Lista de imagens</h4>
							</div>
						</a>
						<a href="../html/configuracao/configuracao_geral.php">
							<div class="col-lg-2 col-md-8 i" >
								<i  class="fas fa-cog"></i>
								<h4>Configurações Gerais</h4>
							</div>
						</a>
						<a href="../html/contribuicao/php/configuracao_doacao.php">
							<div class="col-lg-2 col-md-8 i" >
								<i  class="fa fa-credit-card"></i>
								<h4>Contribuição</h4>
							</div>
						</a>
						<a href="../html/geral/editar_permissoes.php">
							<div class="col-lg-2 col-md-8 i" >
								<i  class="fa fa-key"></i>
								<h4>Permissões</h4>
							</div>
						</a>

					
					</div>
				</div><br>

				<div class="row ">
					<div  id="saude" class="collapse">
						<a href="../html/saude/cadastro_ficha_medica.php">
							<div class="col-lg-2 col-md-8 i" >
								<i  class="far fa-address-book"></i>
								<h4>Cadastro ficha médica</h4>
							</div>
						</a>	
						<a href="../html/saude/profile_paciente.php">
							<div class="col-lg-2 col-md-8 i" >
								<i  class="far fa-address-card"></i>
								<h4>Informações do paciente</h4>
							</div>
						</a>				
					</div>
				</div><br>

				<div class="row ">
					<div  id="pessoas" class="collapse">
						<a href="../html/cadastro_funcionario.php">
							<div class="col-lg-2 col-md-8 i" >
								<i  class="far fa-address-book"></i>
								<h4>Cadastrar Funcionário</h4>
							</div>
						</a>

						<a href="../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php">
							<div class="col-lg-2 col-md-8 i">
									<i  class="far fa-address-card" id="listarFuncionario"></i>
									<h4>Informação funcionários</h4>
							</div>
						</a>

						<a href="../html/atendido/Cadastro_Atendido.php">
							<div class="col-lg-2 col-lg-offset-1 col-md-8 i" >
								<i class="far fa-address-book"></i>
								<h4>Cadastrar Atendido</h4>
							</div>
						</a>

					


						<a href="../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=../html/atendido/Informacao_Atendido.php">
							<div class="col-lg-2 col-md-8 i">
								<form id="listarAtendido" method="POST" action="../controle/control.php">
									<i  class="far fa-address-card" id="listarAtendido"></i>
									<h4>Informação Atendidos</h4>
								</form>
							</div>
						</a>
					</div>
				</div><br>
				<div class="row">
					<div  id="material" class="collapse">
						<a href="../html/cadastro_entrada.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="far fa-clipboard"></i>
								<h4>Entrada</h4>
							</div>
						</a>

						<a href="../html/cadastro_saida.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="far fa-clipboard"></i>
								<h4>Saida</h4>
							</div>
						</a>
						
						<a href="../html/estoque.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-barcode"></i>
								<h4>Estoque</h4>
							</div>
						</a>	
						
						<a href="../html/listar_almox.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-barcode"></i>
								<h4>Almoxarifados</h4>
							</div>
						</a>
						
						<a href="../html/cadastro_produto.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="far fa-clipboard"></i>
								<h4>Produtos</h4>
							</div>
						</a>

						<a href="../html/relatorio.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="far fa-clipboard"></i>
								<h4>Relatórios</h4>
							</div>
						</a>
						
						<a href="../html/listar_entrada.php">
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-barcode"></i>
								<h4>Informação entrada</h4>
							</div>
						</a>
						
						<a href="../html/listar_saida.php">
							<div class="col-lg-2 col-lg-offset-1 col-md-8 i">
								<i  class="fa fa-barcode"></i>
								<h4>Informação saida</h4>
							</div>
						</a>
					
						<a href="../html/adicionar_almoxarifado.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="far fa-clipboard"></i>
								<h4>Adicionar Almoxarifado</h4>
							</div>
						</a>

						
						<!--</a>-->
					</div>
				</div><br>

				<div class="row">
					<div id="memorando" class="collapse">
						<a href="../html/memorando/listar_memorandos_ativos.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-envelope"></i>
								<h4>Caixa de Entrada</h4>


							</div>
						</a>
						<a href="../html/memorando/novo_memorandoo.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-edit"></i>
								<h4>Novo Memorando</h4>
							</div>
						</a>


						<a href="../html/memorando/listar_memorandos_antigos.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-mail-forward"></i>
								<h4>Memorandos despachados</h4>
							</div>
						</a>
					</div>
				</div><br>

				<div class="row">
					<div id="socios" class="collapse">
						<a href="../html/socio/sistema/">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-users"></i>
								<h4>Listar Sócios</h4>
							</div>
						</a>

						<a href="../html/socio/sistema/psocio_geracao.php">	
							<div class="col-lg-2 col-md-8 i">
							<i class="fas fa-hand-holding-usd"></i>
								<h4>Gerar Boleto</h4>
							</div>
						</a>

						<a href="../html/socio/sistema/relatorios_socios.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="far fa-clipboard"></i>
								<h4>Relatórios</h4>
							</div>
						</a>

						<a href="../html/socio/sistema/cobrancas.php">	
							<div class="col-lg-2 col-md-8 i">
							<i class="fas fa-chart-bar"></i>
								<h4>Cobranças</h4>
							</div>
						</a>
					</div>
				</div><br>
				<!--
				<div class="row">
					<a href="">
						<div class="col-lg-2 col-md-8 i">
								<i class="fas fa-dollar-sign"></i>
							<h4>Cadastrar Funcionário</h4>
						</div>
					</a>
					
					<a href="">
						<div class="col-lg-2 col-md-8 i">
							<i  class="far fa-address-card"></i>
							<h4>Cadastrar cargo</h4>
						</div>
					</a>
					
					<a href="">
						<div class="col-lg-2 col-md-8 i">
							<i class="far fa-calendar-alt"></i>
							<h4>Cadastrar Eventos</h4>
						</div>
					</a>

					<a href="">
						<div class="col-lg-2 col-lg-offset-1 col-md-8 i">
							<i class="far fa-folder-open"></i>
							<h4>Gerenciar Documentação</h4>
						</div>
					</a>
				</div><br>-->
			<!-- end: page -->
			</section>
		</div>
	</section>

	<!-- Vendor -->
	<script src="../assets/vendor/jquery/jquery.js"></script>
	<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
	<!-- Specific Page Vendor -->
	<script src="../assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
	<script src="../assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
	<script src="../assets/vendor/jquery-appear/jquery.appear.js"></script>
	<script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
	<script src="../assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
	<script src="../assets/vendor/flot/jquery.flot.js"></script>
	<script src="../assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
	<script src="../assets/vendor/flot/jquery.flot.pie.js"></script>
	<script src="../assets/vendor/flot/jquery.flot.categories.js"></script>
	<script src="../assets/vendor/flot/jquery.flot.resize.js"></script>
	<script src="../assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
	<script src="../assets/vendor/raphael/raphael.js"></script>
	<script src="../assets/vendor/morris/morris.js"></script>
	<script src="../assets/vendor/gauge/gauge.js"></script>
	<script src="../assets/vendor/snap-svg/snap.svg.js"></script>
	<script src="../assets/vendor/liquid-meter/liquid.meter.js"></script>
	<script src="../assets/vendor/jqvmap/jquery.vmap.js"></script>
	<script src="../assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
	<script src="../assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
	<script src="../assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
	<script src="../assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
	<script src="../assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
	<script src="../assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
	<script src="../assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
	<script src="../assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
	<script>
		$(document).ready(function(){
		setTimeout(function(){
			$(".alerta_c").fadeOut();
			window.history.replaceState({}, document.title, window.location.pathname);
		}, 3000);
	});
	</script>

	<!-- Lida com as mensagens -->
	<script src="./geral/msg.js"></script>
		
	<div align="right">
	<iframe src="https://www.wegia.org/software/footer/home.html" width="200" height="60" style="border:none;"></iframe>
	</div>
</body>
</html>