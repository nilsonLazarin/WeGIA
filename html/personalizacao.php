<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}
	require_once "../dao/Conexao.php";
	$pdo = Conexao::connect();
	require_once "../classes/Personalizacao_campo.php";
	
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "personalizacao_display.php";

	// Query das tabelas

	$res = $pdo->query("select * from selecao_paragrafo;");
	$txt_tab = $res->fetchAll(PDO::FETCH_ASSOC);

	$res = $pdo->query("
	select c.id_campo as id_selecao, c.nome_campo, i.imagem as arquivo
	from campo_imagem c
	inner join tabela_imagem_campo ic on c.id_campo = ic.id_campo
	inner join imagem i on ic.id_imagem = i.id_imagem
	where c.tipo = 'img';");
	$img_tab = $res->fetchAll(PDO::FETCH_ASSOC);


	$res = $pdo->query("select nome_campo from campo_imagem where tipo='car';");
	$carrossels = $res->fetchAll(PDO::FETCH_ASSOC);

	function getCarrossel($carrossels, $key, $pdo){
		$nome_campo = $carrossels[$key]["nome_campo"];
		$res = $pdo->query("
		select c.id_campo as id_selecao, c.nome_campo, i.imagem as arquivo
		from campo_imagem c
		inner join tabela_imagem_campo ic on c.id_campo = ic.id_campo
		inner join imagem i on ic.id_imagem = i.id_imagem
		where c.nome_campo='$nome_campo';");
		return $res->fetchAll(PDO::FETCH_ASSOC);
	}

?>
<!doctype html>
<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Personalização</title>

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

	<!-- Personalizacao CSS -->
	<link rel="stylesheet" href="../css/personalizacao-theme.css" />
	
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
					<h2>Edição de Conteúdo</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="./home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Páginas</span></li>
							<li><span>Edição de Conteúdo</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!--start: page-->

				<div class="row">
					<div class="col-md-4 col-lg-2"></div>
					<div class="col-md-8 col-lg-8">

						<!-- Caso as alterações feitas sejam feitas com sucesso -->
						<?php if (isset($_GET['msg'])){ if ($_GET['msg'] == 'success'){ echo('<div class="alert alert-success"><i class="fas fa-check mr-md"></i><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Edição feita com sucesso!</div>');}}?>

						<!-- Caso haja um erro fatal na alteração dos dados -->
						<?php if (isset($_GET['msg'])){ if ($_GET['msg'] == 'error'){ echo('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle mr-md"></i><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'. $_GET["err"] .'</div>');}}?>
						
						<!-- Caso haja um erro na alteração dos dados que não seja fatal -->
						<?php if (isset($_GET['msg'])){ if ($_GET['msg'] == 'warn'){ echo('<div class="alert alert-warning"><i class="fas fa-exclamation-triangle mr-md"></i><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'. $_GET["err"] .'</div>');}}?>
						
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item active">
								<a class="nav-link active" id="img-tab-selector" data-toggle="tab" href="#img-tab" role="tab" aria-controls="img" aria-selected="true">Imagens</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="txt-tab-selector" data-toggle="tab" href="#txt-tab" role="tab" aria-controls="txt" aria-selected="false">Textos</a>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">

							<!-- start: image tab pane-->

							<div class="tab-pane active" id="img-tab" role="tabpanel" aria-labelledby="img-tab">
								<table class="table table-hover">
									<thead>
										<tr>
										<th scope="col" width="40%">Campo</th>
										<th scope="col">Visualização</th>
										</tr>
									</thead>
									<tbody>

										<?php
											foreach ($img_tab as $key => $valor){
												$img_item = new Campo(
													$valor["id_selecao"],
													"img",
													$valor["nome_campo"],
													$valor["arquivo"]
												);
												$img_item->display();
											}
											if ($carrossels){
												foreach ($carrossels as $key => $valor){
													$car_tab = getCarrossel($carrossels, $key, $pdo);
													$car_name = $car_tab[0]["nome_campo"];
													echo('<tr onclick="post(' . "'personalizacao_selecao.php', {tipo: 'car', nome_car: '$car_name'})" . '"' . ">
													<td class='v-center'><div>$car_name</div></td>
													<td>");
													foreach ($car_tab as $key => $valor){
														$car_file = $valor["arquivo"];
														echo("<img src='data:image;base64,$car_file' class='my-sm' width='100%'>");
													}
													echo("</td>
													</tr>");
												}
											}
										?>
										</tr>
									</tbody>
								</table>
							</div>

							<!-- end: image tab pane-->

							<!-- start: text tab pane-->
							
							<div class="tab-pane fade" id="txt-tab" role="tabpanel" aria-labelledby="txt-tab">
								<table class="table table">
									<thead>
										<tr>
										<th scope="col" width="6%">Editar</th>
										<th scope="col" width="20%">Campo</th>
										<th scope="col">Visualização</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($txt_tab as $key => $value){
												$txt_item = new Campo(
													$txt_tab[$key]["id_selecao"],
													"txt",
													$txt_tab[$key]["nome_campo"],
													$txt_tab[$key]["paragrafo"]
												);
												$txt_item->display();
											}
										?>
									</tbody>
								</table>
							</div>

							<!-- end: text tab pane-->

						</div>
					</div>
				</div>
				<!-- end: page -->
				
				<script>

					function post(path, params, method='post') {
						const form = document.createElement('form');
						form.method = method;
						form.action = path;

						for (const key in params) {
							if (params.hasOwnProperty(key)) {
								const hiddenField = document.createElement('input');
								hiddenField.type = 'hidden';
								hiddenField.name = key;
								hiddenField.value = params[key];

								form.appendChild(hiddenField);
							}
						}

						document.body.appendChild(form);
						form.submit();
					}

					// Alterna entre o texto normal e a textarea da linha selecionada
					function tr_select(id){
						selected = id
						var row = window.document.getElementById(id)


						var btn_field = row.firstElementChild

						var btn_togle = btn_field.firstElementChild.children[0]
						var btn_submit = btn_field.firstElementChild.children[1]


						var column_2 = row.children[2]
						var column_3 = row.children[3]

						if (column_2.style.display != 'none'){
							column_2.style.display = 'none'
							column_3.style.display = ''
							column_3.firstElementChild.innerHTML = column_2.innerText
							btn_togle.firstElementChild.className = "fas fa-chevron-left"
							btn_submit.style.display = ''
						}else{
							column_2.style.display = ''
							column_3.style.display = 'none'
							btn_togle.firstElementChild.className = "fas fa-edit"
							btn_submit.style.display = 'none'
						}
					}
					
				</script>

			</section>
		</div>
	</section>
</body>
</html>