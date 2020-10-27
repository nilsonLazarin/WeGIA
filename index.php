<?php
	date_default_timezone_set("America/Sao_Paulo");
	session_start();
	if(isset($_SESSION['usuario'])){
		header ("Location: ./html/home.php");
	}
	
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "html/personalizacao_display.php";

?>
<!doctype html>
<html>
	<head>
		<title><?php display_campo("Titulo","str");?> - <?php display_campo("Subtitulo","str");?></title>
		<meta charset="UTF-8"/>
		<link rel="icon" href="<?php display_campo("Logo","file");?>" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="./assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="./assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="./assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<!---->
		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<script src="./assets/vendor/jquery/jquery.min.js"></script>

		<!-- Skin CSS -->
		<link rel="stylesheet" href="./assets/stylesheets/skins/default.css" />


		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="./css/index-theme.css"/>

				<!-- Head Libs -->
		<script src="./assets/vendor/modernizr/modernizr.js"></script>


		<script>

			
				var erro = <?php echo $_GET['erro'];?>;

			 	if (erro!='erro') {
			 		
			 		alert('Senha e/ou cpf inválido');
			 	}
		</script>

	</head>
	<body>
		
		<div class="row cabecalho">
			
			<div class="col-md-1">
				<a class="logo pull-left">
					<img src="<?php display_campo("Logo","file");?>" height="30" />
				</a>
			</div>

			<div class="col-md-4 descricao">
				<div>
					<p class="lar"><?php display_campo("Titulo","str");?></p>
					<br/>
					<p class="wegia"><?php display_campo("Subtitulo","str");?></p>
				</div>
			</div>

		<form action="./html/login.php" method="POST" enctype="multipart/form-data" class="login">
		
			<div style="margin-top: 1.25%;" class="col col-md-3 formulario">
				<div class="form-group mb-lg"><!--login-->
					
					<div class="input-group input-group-icon"><!--icone-->
						<input name="cpf" type="text" class="form-control input-lg" placeholder="Usuário" />
						<span class="input-group-addon">
							<span class="icon icon-lg">
								<i class="fa fa-user"></i>
							</span>
						</span>
					</div>
				</div>
			</div>

			<div style="margin-top: 1.25%;" class="col col-md-3 formulario">
				<div class="form-group mb-lg"><!--login-->
					
					<div class="input-group input-group-icon"><!--icone-->
						<input name="pwd" type="password" class="form-control input-lg" placeholder="Senha" />
						<span class="input-group-addon">
							<span class="icon icon-lg">
								<i class="fa fa-lock"></i>
							</span>
						</span>
					</div>
					<a href="./html/alterar_senha.php">Esqueceu sua Senha?</a>
				</div>
			</div>
			<input type="submit" value="Entrar" class="btn btn-primary hidden-xs entrar"></input>
			<div class="col-md-1">
				<div class="col-sm-3 text-right">
				</div>
			</div>
		</form>
		</div>
		
		<div class="row corpo">

			<div class="col-md-8 carrosel">

				<div class="inferior">

					<div class="carouselLogin">

						<div id="myCarousel" class="carousel slide" data-ride="carousel">

							<div class="carousel-inner">

								 <!-- start: carrossel -->
								 
								<?php display_carrossel("Carrossel");?>

				 				<!-- end: carrossel -->

							</div>

						</div>

					</div>

				</div>

			</div>
			<div class="col-md-4 informacao">

					<div class="text">

						<!-- start: paragrafos -->

						<?php display_campo("Conheça","txt");?>
						<?php display_campo("Objetivo","txt");?>

						<!-- end: paragrafos -->
						<br><br>
					</div>

			</div>

		</div>

	</body>

	<div class="footer row" style="background-color: black">

		<div class="col-md-8">
			<p style="color: white; margin-left: 10px; margin-top: 8px;"><?php display_campo("Rodapé","str");?></p>
		</div>
		<div class="col-md-4">
			<div class="pull-right">

					<a href="www.facebook.com/LarAbrigoAmorAJesus/" class="btn btn-block btn-social btn-facebook"><span class="fa fa-facebook-square" style="color: white"></span></a>
			</div>
		</div>
		
	</div>
      <!-- Vendor -->
<script src="../assets/vendor/select2/select2.js"></script>
		<script src="./assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="./assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="./assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

		
		<!-- Theme Base, Components and Settings -->
		<script src="./assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="./assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="./assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="./assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="./assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="./assets/javascripts/tables/examples.datatables.tabletools.js"></script>
	</body>
</html>
