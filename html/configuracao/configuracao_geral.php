<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../../index.php");
	}


	
	// Verifica Permissão do Usuário
	require_once '../permissao/permissao.php';
	permissao($_SESSION['id_pessoa'], 9);
	
	// Inclui display de Campos
	require_once "../personalizacao_display.php";

	// Adiciona o Sistema de Mensagem
	require_once "../geral/msg.php";

?>
<!doctype html>
<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Configurações Gerais</title>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="../../assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" href="../../assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon">
	
	<!-- Theme CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/theme.css" />
	
	<!-- Skin CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/skins/default.css" />
	
	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/theme-custom.css">
	
	<!-- Head Libs -->
	<script src="../../assets/vendor/modernizr/modernizr.js"></script>

	<!-- Atualizacao CSS -->
	<link rel="stylesheet" href="../../css/atualizacao.css" />
	
	<!-- Vendor -->
	<script src="../../assets/vendor/jquery/jquery.min.js"></script>
	<script src="../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="../../assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="../../assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../../assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
	<!-- Specific Page Vendor -->
	<script src="../../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
		
	<!-- Theme Base, Components and Settings -->
	<script src="../../assets/javascripts/theme.js"></script>
		
	<!-- Theme Custom -->
	<script src="../../assets/javascripts/theme.custom.js"></script>
		
	<!-- Theme Initialization Files -->
	<script src="../../assets/javascripts/theme.init.js"></script>

	<!-- javascript functions --> <script
	src="../../Functions/onlyNumbers.js"></script> <script
	src="../../Functions/onlyChars.js"></script> <script
	src="../../Functions/mascara.js"></script>

	<!-- jquery functions -->
	<script>
   		document.write('<a href="' + document.referrer + '"></a>');
	</script>

	<script type="text/javascript">
		$(function () {
	      $("#header").load("../header.php");
	      $(".menuu").load("../menu.php");
	    });	
    </script>
    
    <!-- javascript tab management script -->

    <style>
		.btn{
			width: 10%;
		}
	</style>

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
					<h2>Configurações Gerais do Sistema</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="../home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Páginas</span></li>
							<li><span>Configurações Gerais</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>
                <!--start: page-->
				
                <!-- Caso haja uma mensagem do sistema -->
				<?php displayMsg(); getMsgSession("mensagem","tipo");?>

				<!-- <session class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-down"></a>
						</div>
						<h2 class="panel-title">Atualização e Backup</h2>
					</header>
					<div class="panel-body">
						<div class="ls-container">
							<div class="space-between">
								<div>Fazer backup:</div>
								<button id="btn1" class="btn btn-primary" onClick="setLoader(this)"><a href="./backup.php"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></button>
							</div>
							<div class="space-between">
								<div>Atualizar sistema:</div>
								<button id="btn2" class="btn btn-primary" onClick="setLoader(this)"><a href="./atualizacao.php"><i class="fas fa-download" aria-hidden="true"></i></a></button>
							</div>
						</div>
					</div>
				</session>

				<session class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-down"></a>
						</div>
						<h2 class="panel-title">Correção de Erros</h2>
					</header>
					<div class="panel-body">
						<div class="ls-container">
							<div class="space-between">
								<div>Corrigir erros no Estoque:</div>
								<button id="btn1" class="btn btn-primary" onClick="setLoader(this)"><a href="./correcao_estoque.php"><i class="fas fa-wrench"></i></a></button>
							</div>
						</div>
					</div>
				</session> -->

				<session class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-up"></a>
						</div>
						<h2 class="panel-title">Ações Globais</h2>
					</header>
					<div class="panel-body" style="display: none;">
						<div class="ls-container">
							<!-- Conteúdo -->
							<div class="space-between">
								<div>Atualizar sistema:</div>
								<button id="btn2" class="btn btn-primary" onClick="setLoader(this)"><a href="./atualizacao.php"><i class="fas fa-download" aria-hidden="true"></i></a></button>
							</div>
							<div class="space-between">
								<div>Recalcular Estoque:</div>
								<button id="btn1" class="btn btn-primary" onClick="setLoader(this)"><a href="./correcao_estoque.php"><i class="fas fa-wrench"></i></a></button>
							</div>
						</div>
					</div>
				</session>

				<session class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-up"></a>
						</div>
						<h2 class="panel-title">Banco de Dados</h2>
					</header>
					<div class="panel-body" style="display: none;">
						<div class="ls-container">
							<!-- Conteúdo -->
							<div class="space-between">
								<div>Fazer backup:</div>
								<button id="btn1" class="btn btn-primary" onClick="setLoader(this)"><a href="./backup.php"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></button>
							</div>
							<div class="space-between">
								<div>Gerenciar backup:</div>
								<button id="btn1" class="btn btn-primary" onClick="setLoader(this)"><a href="./listar_backup.php"><i class="fa fa-list" aria-hidden="true"></i></a></button>
							</div>
							<!-- <div class="space-between">
								<div>Importar backup:</div>
								<button id="btn1" class="btn btn-primary"><a href="#"><i class="fa fa-undo" aria-hidden="true"></i></a></button>
							</div> -->
						</div>
					</div>
				</session>


			</section>
		</div>
	</section>
</body>
<script>
    function setLoader(btn) {
        btn.firstElementChild.style.display = "none";
        if (btn.childElementCount == 1) {
            loader = document.createElement("DIV");
            loader.className = "loader";
            btn.appendChild(loader);
        }
        window.location.href = btn.firstElementChild.href;
	}
</script>

<!-- Adiciona função de fechar mensagem e tirá-la da url -->
<script src="../geral/msg.js"></script>
</html>