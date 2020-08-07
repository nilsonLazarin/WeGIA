<?php
		session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}
	require_once '../dao/EstoqueDAO.php';
	$_SESSION['estoque'] = (new EstoqueDAO)->ListarTodos();
	if(!isset($_SESSION['estoque']))
	{
		header('Location: ../controle/control.php?metodo=listartodos&nomeClasse=EstoqueControle&nextPage=../html/estoque.php');
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
	if(!is_null($resultado)){
		$id_cargo = mysqli_fetch_array($resultado);
		if(!is_null($id_cargo)){
			$id_cargo = $id_cargo['id_cargo'];
		}
		$resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=22");
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

	require_once "../dao/Conexao.php";

	require_once '../Functions/permissao/permissao.php';

	define('PERMISSAO', permissaoUsuario($_SESSION['id_pessoa'], 2));
	?>
<!doctype html>
<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Estoque</title>
		
	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
  	<!-- Vendor CSS -->
  	<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="../assets/vendor/select2/select2.css" />
	<link rel="stylesheet" href="../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

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


	<!-- javascript functions -->
	<script src="../Functions/onlyNumbers.js"></script>
	<script src="../Functions/onlyChars.js"></script>
	<script src="../Functions/enviar_dados.js"></script>
	<script src="../Functions/mascara.js"></script>

	<!-- CSS Estoque -->

	<link rel="stylesheet" href="./estoque/estoque.css">
		
	<!-- jquery functions -->
   	<script>
	$(function(){
		let estoque=<?= $_SESSION["estoque"] ?> ;
		<?php unset($_SESSION['estoque']); ?>

		$.each(estoque,function(i,item){
			if (item.qtd > 0){
				$("#tabela")
					.append($("<tr class='item "+item.descricao_almoxarifado+" "+item.categoria+"'>")
						.append($("<td>")
							.text(item.codigo))
						.append($("<td>")
							.text(item.descricao))
						.append($("<td>")
							.text(item.categoria))
						.append($("<td >")
							.text(item.qtd))
						.append($('<td />')
							.text(item.descricao_almoxarifado)));
			}
		});
	});
	$(function () {
        $("#header").load("header.php");
        $(".menuu").load("menu.html");
    });

	// Antes do navegador imprimir a página
	window.onbeforeprint = function(event) {
		// Retira a paginação para que todos os registros sejam exibidos
		$('#datatable-default').DataTable().destroy();
	}

	// Depois do navegador imprimir ou cancelar a impressão da página
	window.onafterprint = function(event) { 
		// Recria a tabela com paginação
		$('#datatable-default').DataTable().destroy();
		$('#datatable-default').DataTable({
			aLengthMenu: [
				[10, 25, 50, 100],
				[10, 25, 50, 100]
			],
    		iDisplayLength: 10
		});
	};
	</script>
	
	<style type="text/css">
		/*.table{
			z-index: 0;
		}
		.text-right{
			z-index: 1;
		}*/
		.select{
			/*z-index: 2;*/
			/*float: left;*/
			position: absolute;
			width: 235px;
		}*/
		.select-table-filter{
			width: 140px;
			float: left;
		}
	</style>
</head>
<body>
	<section class="body">
		<!-- start: header -->
		<div id="header"></div>
      	<!-- end: header -->
      	<div class="inner-wrapper">
         	<!-- start: sidebar -->
         	<aside id="sidebar-left" class="sidebar-left menuu"></aside>
			<!-- end: sidebar -->
			<section role="main" class="content-body">
				<header class="page-header">
					<h2>Estoque</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Estoque</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>
				<!-- start: page -->
				<section class="panel" >
					<header class="panel-heading">
						<h2 class="panel-title">Estoque</h2>
					</header>
					<div class="panel-body" >
						<script>
							let filtro = {
								almoxarifado: "todos",
								categoria: "todas"
							}

							function filterItem (){
								let table = $('#datatable-default').DataTable();
								let almox = filtro.almoxarifado == 'todos' ? '' : filtro.almoxarifado ;
								let categ = filtro.categoria == 'todas' ? '' : filtro.categoria ;
 
								table.search( `${almox} ${categ}` ).draw();
							}

							function selectAlmoxarifado(value){
								filtro.almoxarifado = value;
								filterItem();
							}

							function selectCategoria(value){
								filtro.categoria = value;
								filterItem();
							}
						</script>
						<div>
							Almoxarifado: <select class="select-table-filter form-control mb-md" data-table="order-table" oninput="selectAlmoxarifado(this.value)" id="almox">
								<option selected value="todos">Todos</option>
								<?php
									$pdo = Conexao::connect();
									$res = $pdo->query("select descricao_almoxarifado, id_almoxarifado from almoxarifado;");
									$almoxarifado = $res->fetchAll(PDO::FETCH_ASSOC);
									$almoxarifado = JSON_decode(filtrarAlmoxarifado($_SESSION['id_pessoa'], JSON_encode($almoxarifado)));
									foreach ($almoxarifado as $value){
										echo('
										<option value="'.$value->descricao_almoxarifado.'">'.$value->descricao_almoxarifado.'</option>
										');
									}
								?>
							</select>
							Categoria: <select class="select-table-filter form-control mb-md" data-table="order-table" oninput="selectCategoria(this.value)" id="categ">
								<option selected value="todas">Todas</option>
								<?php
									$pdo = Conexao::connect();
									$res = $pdo->query("select descricao_categoria from categoria_produto;");
									$almoxarifado = $res->fetchAll(PDO::FETCH_ASSOC);
									foreach ($almoxarifado as $value){
										echo('
										<option value="'.$value['descricao_categoria'].'">'.$value['descricao_categoria'].'</option>
										');
									}
								?>
							</select>
						</div>
						<div class="select" >
	  					</div>
	  					<button style="float: right;" class="mb-xs mt-xs mr-xs btn btn-default" onclick="window.print();">Imprimir</button>
	  					<br><br>
		  					
						<table class="table table-bordered table-striped mb-none" id="datatable-default">
							<thead>
								<tr>
									<th>Código</th>
									<th>Produto</th>
									<th>Categoria</th>
									<th>Quantidade</th>
									<th>Almoxarifado</th>
								</tr>
							</thead>
							<tbody id="tabela">
							</tbody>
						</table>
					</div>
				</section>
			</section>
		</div>
	</section>
	<!-- end: page -->
	<!-- Vendor -->
		<script src="../assets/vendor/select2/select2.js"></script>
		<script src="../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="../assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="../assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="../assets/javascripts/theme.init.js"></script>
		<!-- Examples -->
		<script src="../assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
	</body>
</html>