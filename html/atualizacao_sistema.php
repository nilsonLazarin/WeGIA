<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}
    // Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "personalizacao_display.php";

?>
<!doctype html>
<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Atualização e Backup</title>

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
	<link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon">
	
	<!-- Theme CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
	
	<!-- Skin CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
	
	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
	
	<!-- Head Libs -->
	<script src="../assets/vendor/modernizr/modernizr.js"></script>

	<!-- Atualizacao CSS -->
	<link rel="stylesheet" href="../css/atualizacao.css" />
	
	<!-- Vendor -->
	<script src="../assets/vendor/jquery/jquery.min.js"></script>
	<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
	<!-- Specific Page Vendor -->
	<script src="../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
		
	<!-- Theme Base, Components and Settings -->
	<script src="../assets/javascripts/theme.js"></script>
		
	<!-- Theme Custom -->
	<script src="../assets/javascripts/theme.custom.js"></script>
		
	<!-- Theme Initialization Files -->
	<script src="../assets/javascripts/theme.init.js"></script>

	<!-- javascript functions --> <script
	src="../Functions/onlyNumbers.js"></script> <script
	src="../Functions/onlyChars.js"></script> <script
	src="../Functions/mascara.js"></script>

	<!-- jquery functions -->
	<script>
   		document.write('<a href="' + document.referrer + '"></a>');
	</script>

	<script type="text/javascript">
		$(function () {
	      $("#header").load("header.php");
	      $(".menuu").load("menu.html");
	    });	
    </script>
    
    <!-- javascript tab management script -->

    

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
					<h2>Atualização e Backup do Sistema</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="./home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Páginas</span></li>
							<li><span>Atualização e Backup</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>
                <!--start: page-->
				
                <!-- Caso as alterações feitas sejam feitas com sucesso -->
				<?php if (isset($_GET['msg'])){ if ($_GET['msg'] == 'success'){ echo('<div class="alert alert-success"><i class="fas fa-check mr-md"></i><a href="#" class="close" onclick="closeMsg()" data-dismiss="alert" aria-label="close">&times;</a>'. ($_GET["sccs"] ? $_GET["sccs"] : "Operação concluida com sucesso!") . '<pre>'.base64_decode($_GET['log']).'</pre></div>');}}?>

				<!-- Caso haja um erro fatal na alteração dos dados -->
				<?php if (isset($_GET['msg'])){ if ($_GET['msg'] == 'error'){ echo('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle mr-md"></i><a href="#" class="close" onclick="closeMsg()" data-dismiss="alert" aria-label="close">&times;</a>'. ($_GET["err"] ? $_GET["err"] : "Houve um erro ao atualizar o sistema") .'</div>');}}?>
				
                <div class="tab-content ls-container">
                    <div class="space-between">
                        <div>Fazer backup:</div>
                        <button id="btn1" class="btn btn-primary" onClick="setLoader(this)"><a href="geral/backup.php"><i class="fa fa-floppy-o" aria-hidden="true"></i></a></button>
                    </div>
                    <div class="space-between">
                        <div>Atualizar sistema:</div>
                        <button id="btn2" class="btn btn-primary" onClick="setLoader(this)"><a href="geral/atualizacao.php"><i class="fa fa-upload" aria-hidden="true"></i></a></button>
                    </div>
                </div>
				<!--end: page-->
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
	
	function closeMsg(){
		window.history.replaceState({}, document.title, window.location.pathname);
	}
</script>
</html>