<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}
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
	<link rel="icon" href="../img/logofinal.png" type="image/x-icon">

	<!-- Skin CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="../assets/vendor/modernizr/modernizr.js"></script>
	<script src="../Functions/lista.js"></script>

</head>
<body>
	<section class="body">
		<!-- start: header -->
		<header class="header">
			<div class="logo-container">
				<a href="home.php" class="logo">
					<img src="../img/logofinal.png" height="35" alt="Porto Admin" />
				</a>
				<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
					<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</div>
			
			<!-- start: search & user box -->
			<div class="header-right">
				<span class="separator"></span>
				<div id="userbox" class="userbox">
					<a href="#" data-toggle="dropdown">
						<figure class="profile-picture">
							<img src="../img/semfoto.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="../assets/images/!logged-user.jpg" />
						</figure>
						<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
							<span class="name">Usuário</span>
							<span class="role">Funcionário</span>
						</div>
						<i class="fa custom-caret"></i>
					</a>
			
					<div class="dropdown-menu">
						<ul class="list-unstyled">
							<li class="divider"></li>
							<li>
								<a role="menuitem" tabindex="-1" href="../html/alterar_senha.php"><i class="glyphicon glyphicon-lock"></i> Alterar senha</a>
							</li>
							<li>
								<a role="menuitem" tabindex="-1" href="./logout.php"><i class="fa fa-power-off"></i> Sair da sessão</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<!-- end: search & user box -->
		</header>


		<div class="inner-wrapper">
			<!-- start: sidebar -->
			<aside id="sidebar-left" class="sidebar-left">
				<div class="sidebar-header">
					<div class="sidebar-title">
						Menu
					</div>
					<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
				
				<div class="nano">
					<div class="nano-content">
						<nav id="menu" class="nav-main" role="navigation">
							<ul class="nav nav-main">
								<li>
									<a href="home.php">
										<i class="fa fa-home" aria-hidden="true"></i>
										<span>Início</span>
									</a>
								</li>
								<li class="nav-parent nav-active">
									<a>
										<i class="fa fa-copy"></i>
										<span>Pessoas</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="cadastro_funcionario.php">
												 Cadastrar funcionário
											</a>
										</li>
										<li>
											<a href="cadastro_interno.php">
												 Cadastrar interno
											</a>
										</li>
										<!--<li>
											<a href="cadastro_voluntario.php">
												 Cadastrar voluntário
											</a>
										</li>
										<li>
											<a href="cadastro_voluntario_judicial.php">
												 Cadastrar voluntário judicial
											</a>
										</li>-->
										<li>
											<a href="../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php">
												 Informações funcionarios
											</a>
										</li>
										<li>
											<a href="../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=../html/informacao_interno.php">
												 Informações interno
											</a>
										</li>
									</ul>
								</li>

								<li class="nav-parent nav-active">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Material e Patrimônio</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="../html/cadastro_entrada.php">
												 Cadastrar Produtos
											</a>
										</li>
										<li>
											<a href="../html/cadastro_saida.php">
												 Saida de Produtos
											</a>
										</li>
										<li>
											<a href="../html/estoque.php">
												 Estoque
											</a>
										</li>
										<li>
											<a href="../html/listar_almox.php">
												 Almoxarifados
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</aside>
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
					<a href="#" >
						<div class="col-lg-2 col-md-8 i" data-toggle="collapse" href="#pessoas" >
							<i  class="far fa-address-book"></i>
							<h4>Pessoa</h4>
						</div>
					</a>
					<a href="#">
						<div class="col-lg-2 col-md-8 i" data-toggle="collapse" href="#material">
							<i  class="far fa-address-book"></i>
							<h4>Material e Patrimônio</h4>
						</div>
					</a>
				</div>
				<div class="row ">
					<div  id="pessoas" class="collapse">
						<a href="../html/cadastro_funcionario.php">
							<div class="col-lg-2 col-md-8 i" >
								<i  class="far fa-address-book"></i>
								<h4>Cadastrar Funcionário</h4>
							</div>
						</a>

						<a href="../html/cadastro_interno.php">
							<div class="col-lg-2 col-lg-offset-1 col-md-8 i" >
								<i class="far fa-address-book"></i>
								<h4>Cadastrar Interno</h4>
							</div>
						</a>

						<a href="../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php">
							<div class="col-lg-2 col-md-8 i">
									<i  class="far fa-address-card" id="listarFuncionario"></i>
									<h4>Informação funcionarios</h4>
							</div>
						</a>

						<a href="../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=../html/informacao_interno.php">
							<div class="col-lg-2 col-md-8 i">
								<form id="listarInterno" method="POST" action="../controle/control.php">
									<i  class="far fa-address-card" id="listarInterno"></i>
									<h4>Informação internos</h4>
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
								<h4>Entrada de itens</h4>
							</div>
						</a>

						<a href="../html/listar_entrada.php">
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-barcode"></i>
								<h4>Informação entrada</h4>
							</div>
						</a>

						<a href="../html/cadastro_saida.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="far fa-clipboard"></i>
								<h4>Saida de Itens</h4>
							</div>
						</a>
						
						<a href="../html/listar_saida.php">
							<div class="col-lg-2 col-lg-offset-1 col-md-8 i">
								<i  class="fa fa-barcode"></i>
								<h4>Informação saida</h4>
							</div>
						</a>

						<a href="../html/estoque.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-barcode"></i>
								<h4>Estoque</h4>
							</div>
						</a>	
					
						<a href="../html/adicionar_almoxarifado.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="far fa-clipboard"></i>
								<h4>Adicionar Almoxarifado</h4>
							</div>
						</a>

						<a href="../html/cadastro_produto.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="far fa-clipboard"></i>
								<h4>Cadastrar Produtos</h4>
							</div>
						</a>
						
						<a href="../html/listar_almox.php">	
							<div class="col-lg-2 col-md-8 i">
								<i  class="fa fa-barcode"></i>
								<h4>Almoxarifado</h4>
							</div>
						</a>

						
						<!--</a>-->
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
		
	<!-- Theme Base, Components and Settings -->
	<script src="../assets/javascripts/theme.js"></script>
		
	<!-- Theme Custom -->
	<script src="../assets/javascripts/theme.custom.js"></script>
		
	<!-- Theme Initialization Files -->
	<script src="../assets/javascripts/theme.init.js"></script>

	<!-- Examples -->
	<script src="../assets/javascripts/dashboard/examples.dashboard.js"></script>
</body>
</html>