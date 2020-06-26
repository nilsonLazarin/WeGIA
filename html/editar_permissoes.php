<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}
	
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
	$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$id_pessoa = $_SESSION['id_pessoa'];
	$resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
	$id_cargo = mysqli_fetch_array($resultado)['id_cargo'];
	$resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=21");
	if(mysqli_num_rows($resultado)){
		$permissao = mysqli_fetch_array($resultado);
		$permissao = $permissao['id_acao'];
		if($permissao['id_acao'] == 1){
			$msg = "Você não tem as permissões necessárias para essa página.";
		}
	}else{
        $permissao = 1;
        $msg = "Você não tem as permissões necessárias para essa página.";
	}
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
    require_once "personalizacao_display.php";
      $cargo = mysqli_query($conexao, "SELECT * FROM cargo");
      $acao = mysqli_query($conexao, "SELECT * FROM acao");
      $recurso = mysqli_query($conexao, "SELECT * FROM recurso");
?>
<!doctype html>
<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Adicionar Almoxarifado</title>

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
	<link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">

	<!-- Theme CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="../assets/vendor/modernizr/modernizr.js"></script>

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
		
</head>
<body>
	<section class="body">

		<!-- start: header -->
		<header id="header" class="header">
			
		<!-- end: search & user box -->
		</header>
		<!-- end: header -->
		<div class="inner-wrapper">
			<!-- start: sidebar -->
			<aside id="sidebar-left" class="sidebar-left menuu"></aside>
			<!-- end: sidebar -->

			<section role="main" class="content-body">
				<header class="page-header">
					<h2>Permissões</h2>
					
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Páginas</span></li>
							<li><span>Editar permissões</span></li>
						</ol>
					
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!-- start: page -->
				<div class="row">
					<div class="col-md-4 col-lg-2" style="visibility: hidden;"></div>
					<div class="col-md-8 col-lg-8" >
						<div class="tabs">
							<ul class="nav nav-tabs tabs-primary">
								<li class="active">
									<a href="#overview" data-toggle="tab">Editar permissões
									</a>
								</li>
							</ul>
							<div class="tab-content">
								<div id="overview" class="tab-pane active">
									<fieldset>
										<form method="post" id="formulario" action="../controle/control.php">
										<?php
											if($permissao == 1){
												echo($msg);
											}else{
										?>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Cargo</label>
												<a href="adicionar_categoria.php">
													<i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i>
												</a>
												<div class="col-md-6">
													<select name="id_cargo" id="id_cargo" class="form-control input-lg mb-md">
                                                    <option selected disabled>Selecionar</option>
                                                        <?php
                                                            while($row = $cargo->fetch_array(MYSQLI_NUM))
                                                            {
                                                             echo "<option value=".$row[0].">".$row[1]."</option>";
                                                            }             
                                                        ?>
													</select>
												</div>	
                                            </div>
                                            <div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Permissões</label>
												
												<div class="col-md-6">
													<select name="id_acao" id="id_acao" class="form-control input-lg mb-md">
                                                    <option selected disabled>Selecionar</option>
                                                    <?php
                                                            while($row = $acao->fetch_array(MYSQLI_NUM))
                                                            {
                                                             echo "<option value=".$row[0].">".$row[1]."</option>";
                                                            }             
                                                        ?>
													</select>
												</div>	
                                            </div>
                                            <div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Recurso</label>
												<div class="col-md-6">
													<select name="id_categoria" id="id_recurso" class="form-control input-lg mb-md">
                                                    <option selected disabled>Selecionar</option>
                                                    <?php
                                                            while($row = $recurso->fetch_array(MYSQLI_NUM))
                                                            {
                                                             echo "<option value=".$row[0].">".$row[1]."</option>";
                                                            }             
                                                        ?>
													</select>
												</div>	
											</div>
											<input type="hidden" name="nomeClasse" value="FuncionarioControle">
											<input type="hidden" name="metodo" value="adicionar_permissao">
											<div class="row">
												<div class="col-md-9 col-md-offset-3">
													<button id="enviar" class="btn btn-primary" type="submit">Enviar</button>
													<input type="reset" class="btn btn-default">
													<a href="listar_permissoes.php" style="color: white; text-decoration:none;">
														<button class="btn btn-success" type="button">Listar permissões</button></a>
												</div>
											</div>
											<?php
												}
											?>
										</form>
									</fieldset>	
								</div>
							</div>
						</div>
					</div>
				</div>
			<!-- end: page -->
			</section>
		</div>	
		<aside id="sidebar-right" class="sidebar-right">
			<div class="nano">
				<div class="nano-content">
					<a href="#" class="mobile-close visible-xs">
						Collapse <i class="fa fa-chevron-right"></i>
					</a>
				</div>
			</div>
		</aside>
	</section>
</body>
</html>
