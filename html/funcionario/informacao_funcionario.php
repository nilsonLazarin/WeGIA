<?php
	session_start();
	if(!isset($_SESSION['usuario']))
	{
		header ("Location: ../index.php");
	}
	if(!isset($_SESSION['funcionarios']))
	{
		header('Location: ../../controle/control.php?metodo=listartodos&nomeClasse=FuncionarioControle&nextPage=../html/funcionario/informacao_funcionario.php');
	}
	$config_path = "config.php";
	if(file_exists($config_path))
	{
		require_once($config_path);
	}
	else
	{
		while(true)
		{
			$config_path = "../" . $config_path;
			if(file_exists($config_path)) break;
		}
		require_once($config_path);
	}
	
	$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$id_pessoa = $_SESSION['id_pessoa'];
	$resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
	if(!is_null($resultado))
	{
		$id_cargo = mysqli_fetch_array($resultado);
		if(!is_null($id_cargo))
		{
			$id_cargo = $id_cargo['id_cargo'];
		}
		$resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=11");
		if(!is_bool($resultado) and mysqli_num_rows($resultado))
		{
			$permissao = mysqli_fetch_array($resultado);
			if($permissao['id_acao'] < 5)
			{
        		$msg = "Você não tem as permissões necessárias para essa página.";
        		header("Location: ../home.php?msg_c=$msg");
			}
			$permissao = $permissao['id_acao'];
		}
		else
		{
        	$permissao = 1;
          	$msg = "Você não tem as permissões necessárias para essa página.";
          	header("Location: ../home.php?msg_c=$msg");
		}	
	}
	else
	{
		$permissao = 1;
    	$msg = "Você não tem as permissões necessárias para essa página.";
    	header("Location: ../../home.php?msg_c=$msg");
	}	
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once ROOT."/controle/FuncionarioControle.php";
	require_once "../personalizacao_display.php";
?>
<!doctype html>
<html class="fixed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">

	<title>Informações</title>
		
	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="../../assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="../../assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="../../assets/vendor/select2/select2.css" />
	<link rel="stylesheet" href="../../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="../../assets/vendor/modernizr/modernizr.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		
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

	<!-- javascript functions -->
	<script src="../../Functions/onlyNumbers.js"></script>
	<script src="../../Functions/onlyChars.js"></script>
	<script src="../../Functions/enviar_dados.js"></script>
	<script src="../../Functions/mascara.js"></script>

	<!-- jquery functions -->
   <script>
	   
	function clicar(id)
	{
		window.location.href = "profile_funcionario.php?id_funcionario="+id;
	}
	
	$(function(){
		
		var funcionarios=<?php
			$response = new FuncionarioControle;
			$response->ListarTodos();
			echo $_SESSION['funcionarios'];?> ;
			console.log(funcionarios);

		$.each(funcionarios,function(i,item){
			$("#tabela")
				.append($("<tr>")
					.attr("onclick", "clicar('" + item.id_funcionario+"')")
					.attr("class","teste")
					.append($("<td>")
						.text(item.nome+' '+item.sobrenome))
					.append($("<td>")
						.text(item.cpf))
					.append($("<td >")
						.text(item.cargo))
					.append($('<td />')
						.attr('onclick','clicar("'+item.id_almoxarifado+'")')
					.html('<i class="glyphicon glyphicon-pencil"></i>')));
		});
	});
	$(function () {
        $("#header").load("../header.php");
        $(".menuu").load("../menu.php");
    });
	</script>
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
					<h2>Informações</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="../home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Informações Funcionário</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>
				<!-- start: page -->
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-down"></a>
						</div>
						<h2 class="panel-title">Funcionário</h2>
					</header>

					<!-- start: page -->
					
                                          

					<!-- start: page -->
						<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
								</div>
								<h2 class="panel-title">Selecione a situação:</h2><br>
                                <form method="GET" action="#" id="select_situacao" name="select_situacao">
									<select name="select_situacao" id="situacao">
										<?php
											$result_situacao = "SELECT * FROM situacao ORDER BY id_situacao";
											$resultado_situacao = mysqli_query($conexao, $result_situacao);
											while($row_situacao = mysqli_fetch_assoc($resultado_situacao)){?>
												<option value = "<?php echo $row_situacao['id_situacao']; ?>">
													<?php echo $row_situacao['situacoes'];?>
												</option> <?php 
											}
											?>
									</select>
									<br> <input type="submit"  value='Listar' name='listar' id='listar' class='mb-xs mt-xs mr-xs btn btn-primary'/>
							</form>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Cpf</th>
											<th>Cargo</th>
											<th>Ação</th>
										</tr>
									</thead>
									<tbody id="tabela">
										
									</tbody>
								</table>
							</div><br>
						</section>
					<!-- end: page -->

		<!-- Vendor -->
		<script src="../../assets/vendor/select2/select2.js"></script>
		<script src="../../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="../../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="../../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="../../assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="../../assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="../../assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="../../assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="../../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="../../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
					
		<div align="right">
		<iframe src="https://www.wegia.org/software/footer/funcionario.html" width="200" height="60" style="border:none;"></iframe>
		</div>
	</body>
</html>
