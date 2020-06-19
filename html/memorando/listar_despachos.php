<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

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

session_start();

if(!isset($_SESSION['usuario'])){
	header ("Location: ".WWW."index.php");
}

require_once ROOT."/controle/memorando/DespachoControle.php";
require_once ROOT."/controle/FuncionarioControle.php";
require_once ROOT."/controle/memorando/MemorandoControle.php";

if(isset($_GET["arq"]))
{
	$arquivado=$_GET["arq"];
}

$id_memorando=$_GET['id_memorando'];

$despachos = new DespachoControle;
$despachos->listarTodos();

$funcionarios = new FuncionarioControle;
$funcionarios->listarTodos2();

$ultimoDespacho =  new MemorandoControle;
$ultimoDespacho->buscarUltimoDespacho($id_memorando);
	
// Adiciona a Função display_campo($nome_campo, $tipo_campo)
require_once ROOT."/html/personalizacao_display.php";
?>

<!DOCTYPE html>

<html class="fixed">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Caixa de entrada</title>
        
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="<?php echo WWW;?>assets/vendor/modernizr/modernizr.js"></script>
        
    <!-- Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        
    <!-- Specific Page Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        
    <!-- Theme Base, Components and Settings -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
        
    <!-- Theme Custom -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
    <!-- Theme Initialization Files -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>


    <!-- javascript functions -->
    <script src="<?php echo WWW;?>Functions/onlyNumbers.js"></script>
    <script src="<?php echo WWW;?>Functions/onlyChars.js"></script>
    <script src="<?php echo WWW;?>Functions/mascara.js"></script>
    <script src="<?php echo WWW;?>Functions/memorando/mostra_arquivo.js"></script>
        
    <!-- jquery functions -->

   	<script>
	$(function(){
		var despacho=<?php echo $_SESSION['despacho']?>;
		$.each(despacho,function(i,item){
			$("#tabela")
				.append($("<tr id="+item.id+">")
					.append($("<td>")
						.text(item.id))
					.append($("<td>")
						.text(item.remetente))
					.append($("<td>")
						.text(item.destinatario))
					.append($("<td>")
						.html(item.texto+"<a href=<?php echo WWW;?>controle/control.php?id_despacho="+item.id+"&id_memorando="+<?php echo $id_memorando;?>+"&nomeClasse=AnexoControle&metodo=listarTodos&modulo=memorando target=_self><img src=<?php echo WWW;?>img/clip.png heigh=30px width=30px></a>"))
					.append($("<td >")
						.text(item.data)));
		});

        $("#header").load("<?php echo WWW;?>html/header.php");
        $(".menuu").load("<?php echo WWW;?>html/menu.php");

        var id_memorando = <?php echo $_GET['id_memorando']?>;
        $("#id_memorando").val(id_memorando);
    });
	</script>

	<style type="text/css">

		.select{
			position: absolute;
			width: 235px;
		}
		.select-table-filter{
			width: 140px;
			float: left;
		}

		#arquivos
		{
			margin-top: -25px; 
    		position: absolute;
    		z-index: 1;
    		background-color: #e6e5e5;
    		width: 50%;
    		top: 15%;
    		left: 50%;
    		transform: translate(-50%, -50%);
		}

		#x
		{
			display: block;
			box-shadow: none;
			float: right;
		}
		#titulo
		{
			color: #ffff;
			font-weight: 450;
		}

		#link
		{
			background-color: #e6e5e5;
			border-radius: 0px;
			border: none;
			color: #000000;
		}
		#link:hover
		{
			background-color: #cacaca;
		}

		.pagination > li.active a, html.dark .pagination > li.active a
		{
			z-index: 1;
		}

		.panel-body
		{
			margin-bottom: 15px;
		}

		input[type="file"] {
			margin-bottom: 10px;
			margin-top: 15px;
		}

		#semarquivos
		{
			margin: 15px;
    		font-size: 15px;
		}

		#barra
		{
			background-color: #1d2127;
		}

		.col-md-3 {
    		width: 5%;
		}

		@media (min-width: 992px)
		{
			.col-md-3 {
    			width: 10%;
			}
		}

		#despacho
		{
			width: 700px;
			height: 400px;
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
					<h2>Despacho</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="<?php echo WWW;?>html/home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Despacho</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>
				<section class="panel" >
				<!-- start: page -->
				<?php
				if($_SESSION['ultimo_despacho'][0]['id_destinatarioo']!=$_SESSION['id_pessoa'] AND $arquivado!=1)
				{
				?>
				<script>
					$(".panel").html("<p>Desculpe, você não tem acesso à essa página</p>");
				</script>
				<?php
				}
				else
				{
				?>
					<header class="panel-heading">
						<h2 class="panel-title">Despacho</h2>
					</header>
					<div class="panel-body" >
						<div class="select" >
							<select class="select-table-filter form-control mb-md" data-table="order-table">
								<option selected disabled>Despacho</option>
							</select float:right;></h5>
	  					</div>
	  					<button style="float: right;" class="mb-xs mt-xs mr-xs btn btn-default">Imprimir</button>
	  					<br><br>
		  					
						<table class="table table-bordered table-striped mb-none" id="datatable-default">
							<thead>
								<tr>
									<th>codigo</th>
									<th>remetente</th>
									<th>destinatario</th>
									<th>despacho</th>
									<th>data</th>
								</tr>
							</thead>
							<tbody id="tabela">
							</tbody>
						</table>
					</div>							
					<?php
						if(!isset($_GET["arq"]))
							{
					?>
								<header class="panel-heading">
									<h2 class="panel-title">Despachar memorando</h2>
								</header>
								<div class="panel-body">
								<?php
									echo "<form action='".WWW."controle/control.php' method='post' enctype='multipart/form-data'>";
									?>
										<div class='form-group'>
											<label for=destinatario id=etiqueta_destinatario class='col-md-3 control-label'>Destino </label>
											<div class='col-md-6'>
												<select id=destinatario name=destinatario required class='select-table-filter form-control mb-md'></select>
											</div>
										</div>
										<div class='form-group'>
											<label for=anexo id=etiqueta_anexo class='col-md-3 control-label'>Arquivo </label>
											<div class='col-md-6'>
												<input type='file' name='anexo[]' id='anexo' multiple>
											</div>
										</div>
										<div class='form-group'>
											<label for=texto id=etiqueta_despacho class='col-md-3 control-label'>Despacho </label>
											<div class='col-md-6'>
												<textarea cols='30' rows='5' id='despacho' name='texto' required class='form-control'></textarea>
											</div>
										</div>
										<div class='row'>
											<div class='col-md-9 col-md-offset-7'>
												<input type="hidden" name="nomeClasse" value="DespachoControle">
												<input type="hidden" name="metodo" value="incluir">
												<input type="hidden" name="modulo" value="memorando">
												<input type="hidden" name="id_memorando" id="id_memorando">
												<input type='submit' value='Enviar' name='enviar' id='enviar' class='btn btn-primary'>
											</div>
										</div>
									</form>
								</div>
<?php
}?>
	<div id="arquivos" hidden>
		<!--header class="panel-heading"-->
		<header class="panel-heading" id="barra">
			<div class="row">
				<div class="col-md-6">
					<h2 class="panel-title col-md-6" id="titulo" style="margin: 15px 0 0 15px;">Arquivos</h2>
				</div>
				<div class="col-md-6">
					<button type="button" id="x" class='mb-xs mt-xs mr-xs btn btn-default'><img src="<?php echo WWW;?>img/x.png" width="15px" height="15px"></button>
				</div>
					</header>
			</div>
		<!--/header-->
	</div>
	</div>
	</div>
<?php } ?> 
				</section>
			</section>
		</div>
	</section>
	
	<!-- end: page -->
	<!-- Vendor -->
		<script src="<?php echo WWW;?>assets/vendor/select2/select2.js"></script>
		<script src="<?php echo WWW;?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="<?php echo WWW;?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>
		<!-- Examples -->
		<script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
	<?php
		if(isset($_SESSION['arquivos']))
			{
				$Anexo=$_SESSION["arquivos"];
	?>
			<script>
				$(function(){	
					$("#arquivos").show();
					var anexo=<?php echo $Anexo;?>;
					console.log(anexo);
					$.each(anexo,function(i,item){
            			$("#arquivos")
                			.append("<button type='button' class='btn btn-primary btn-lg btn-block' id='link' onclick=debugBase64('"+item.anexo+"')>"+item.nome+"."+item.extensao+"</button>");
                	});
                	if(anexo.length==0)
                	{
                		$("#arquivos").append("<p id='semarquivos'>Não há arquivos anexados nesse despacho</p>")
                	}
            $("#x").click(function(){
			document.getElementById("arquivos").style.display = "none";
			});
        	});
			</script>
	<?php
		}
		unset($_SESSION["arquivos"]);
	?>
	<script>
		$(function(){
		var funcionario=<?php echo $_SESSION['funcionarios2']?>;
    		$.each(funcionario,function(i,item){	
			$("#destinatario")
				.append($("<option id="+item.id_pessoa+" value="+item.id_pessoa+" name="+item.id_pessoa+">"+item.nome+"</option>"));
		});    
		});           	
	</script>
	</body>
</html>