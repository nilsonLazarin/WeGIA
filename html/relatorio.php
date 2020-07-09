<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}
	require_once("../dao/Conexao.php");
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
	if(!is_null($resultado)){
		$id_cargo = mysqli_fetch_array($resultado);
		if(!is_null($id_cargo)){
			$id_cargo = $id_cargo['id_cargo'];
		}
		$resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=25");
		if(!is_bool($resultado) and mysqli_num_rows($resultado)){
			$permissao = mysqli_fetch_array($resultado);
			if($permissao['id_acao'] < 5){
        $msg = "Você não tem as permissões necessárias para essa página.";
        header("Location: ./home.php?msg_c=$msg");
			}
			$permissao = $permissao['id_acao'];
		}else{
        	$permissao = 1;
          $msg = "Você não tem as permissões necessárias para essa página.";
          header("Location: ./home.php?msg_c=$msg");
		}	
	}else{
		$permissao = 1;
    $msg = "Você não tem as permissões necessárias para essa página.";
    header("Location: ./home.php?msg_c=$msg");
	}	
    // Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "personalizacao_display.php";




?>
<!doctype html>
<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Geração de Relatório</title>

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
					<h2>Geração de Relatório</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="./home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Páginas</span></li>
							<li><span>Geração de Relatório</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>
                <!--start: page-->
                <div class="tab-content"> 
                    <div id="overview" class="tab-pane active">
                        <form class="form-horizontal" method="post" action="relatorio_geracao.php">
							<h4 class="mb-xlg">Tipo de Relatório</h4>
							<h5 class="obrig">Campos Obrigatórios(*)</h5>

							<div class="form-group">
                              <label class="col-md-3 control-label" for="type">Tipo de Relatório <span class="obrig">*</span></label>
                              <div class="col-md-8">
								  <select name="tipo_relatorio" oninput="changeType(this.value)" id="tipo-relat" required>
									  <option value="entrada">Relatório de Entrada</option>
									  <option value="estoque">Relatório de Estoque</option>
									  <option value="saida">Relatório de Saída</option>
								  </select>
                              </div>
                            </div>

                            <h4 class="mb-xlg">Parâmetros do relatório</h4>

							<div class="form-group" id='orig'>
								<label class="col-md-3 control-label">Origem</label>
								<div class="col-md-8">
								<select name="origem">
									  <option value="">Todas as Opções</option>
									  <?php
											$pdo = Conexao::connect();
											$res = $pdo->query("select * from origem;");
											$origem = $res->fetchAll(PDO::FETCH_ASSOC);
											foreach ($origem as $value){
												echo('
												<option class="option-origem" value="'.$value['id_origem'].'">'.$value['nome_origem'].'</option>
												');
											}
										?>
								  </select>
								</div>
							</div>

							<div class="form-group" id='dest' style="display: none;">
								<label class="col-md-3 control-label">Destino</label>
								<div class="col-md-8">
								<select name="destino">
									  <option value="">Todas as Opções</option>
									  <?php
											$pdo = Conexao::connect();
											$res = $pdo->query("select * from destino;");
											$destino = $res->fetchAll(PDO::FETCH_ASSOC);
											foreach ($destino as $value){
												echo('
												<option class="option-destino" value="'.$value['id_destino'].'">'.$value['nome_destino'].'</option>
												');
											}
										?>
								  </select>
								</div>
							</div>
							
							<div class="form-group" id='tipo-entrada'>
								<label class="col-md-3 control-label">Tipo de Entrada</label>
								<div class="col-md-8">
								<select name="tipo">
									  <option value="">Todas as Opções</option>
									  <?php
											$pdo = Conexao::connect();
											$res = $pdo->query("select * from tipo_entrada;");
											$entrada = $res->fetchAll(PDO::FETCH_ASSOC);
											foreach ($entrada as $value){
												echo('
												<option value="'.$value['id_tipo'].'">'.$value['descricao'].'</option>
												');
											}
										?>
								  </select>
								</div>
							</div>
							
							<div class="form-group" id='tipo-saida' style="display: none;">
								<label class="col-md-3 control-label">Tipo de Saida</label>
								<div class="col-md-8">
								<select name="">
									  <option value="">Todas as Opções</option>
									  <?php
											$pdo = Conexao::connect();
											$res = $pdo->query("select * from tipo_saida;");
											$saida = $res->fetchAll(PDO::FETCH_ASSOC);
											foreach ($saida as $value){
												echo('
												<option value="'.$value['id_tipo'].'">'.$value['descricao'].'</option>
												');
											}
										?>
								  </select>
								</div>
                            </div>

							<div class="form-group" id='resp'>
								<label class="col-md-3 control-label">Responsável</label>
								<div class="col-md-8">
								<select name="responsavel">
									  <option value="">Todas as Opções</option>
									  <?php
											$pdo = Conexao::connect();
											$res = $pdo->query("select * from pessoa;");
											$resp = $res->fetchAll(PDO::FETCH_ASSOC);
											foreach ($resp as $value){
												echo('
												<option value="'.$value['id_pessoa'].'">'.$value['nome'].'</option>
												');
											}
										?>
								  </select>
								</div>
							</div>

                            <div class="form-group" id='per'>
								<label class="col-md-3 control-label" for="profileCompany">Período</label>
								<div class="col-md-8">
									<input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data_inicio" max="9999-12-31">
									<br>
									<input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data_fim" max="9999-12-31">
								</div>
                            </div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Almoxarifado</label>
								<div class="col-md-8">
									<select name="almoxarifado">
										<option value="">Todas as Opções</option>
										<?php
											$pdo = Conexao::connect();
											$res = $pdo->query("select * from almoxarifado;");
											$almoxarifado = $res->fetchAll(PDO::FETCH_ASSOC);
											foreach ($almoxarifado as $value){
												echo('
												<option value="'.$value['id_almoxarifado'].'">'.$value['descricao_almoxarifado'].'</option>
												');
											}
										?>
									</select>
								</div>
                            </div>

                            <div class="form-group">
                                <div class="center-content">
                                    <input type="submit" value="Gerar" class="btn btn-primary" style="width: fit-content;">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
				<!--end: page-->
			</section>
		</div>
	</section>
</body>
<script src="./relatorios/relatorio.js"></script>
</html>