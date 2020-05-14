<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

session_start();

if(!isset($_SESSION['usuario'])){
	header ("Location: ../index.php");
}

include "../memorando/conexao.php";

$id_memorando=$_GET["desp"];

if(isset($_GET["arq"]))
{
	$arquivado=$_GET["arq"];
}

$comando1="update memorando set id_status_memorando='6' where id_memorando='$id_memorando'";
$query1=mysqli_query($conexao, $comando1);
$linhas1=mysqli_affected_rows($conexao);

$memorandos=array();
$anexos=array();

$comando="select pessoa.nome, despacho.texto, despacho.id_remetente, despacho.data, despacho.id_destinatario, despacho.id_despacho from despacho join pessoa on despacho.id_remetente=pessoa.id_pessoa where id_memorando=".$id_memorando." order by despacho.data desc";
$query=mysqli_query($conexao, $comando);
$linhas=mysqli_num_rows($query);

$comando3="select pessoa.nome from despacho join pessoa on despacho.id_destinatario=pessoa.id_pessoa where id_memorando=".$id_memorando;
$query3=mysqli_query($conexao, $comando3);
$linhas3=mysqli_num_rows($query3);

for($i=0; $i<$linhas; $i++)
{

	$consulta=mysqli_fetch_row($query);
	$consulta3=mysqli_fetch_row($query3);
	$memorandos[$i]=array('remetente'=>$consulta[0], 'mensagem'=>$consulta[1], 'data'=>$consulta[3], 'destinatario'=>$consulta3[0], 'id'=>$consulta[5]);
	}

$memorando=json_encode($memorandos);
	
// Adiciona a Função display_campo($nome_campo, $tipo_campo)
require_once "personalizacao_display.php";
?>

<!DOCTYPE html>

<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Despachos</title>
		
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
	<script src="../Functions/mascara.js"></script>
		
	<!-- jquery functions -->

   	<script>
	$(function(){
		var memorando=<?php echo $memorando?> ;
		var tamanho=0;
		$.each(memorando,function(i,item){
				
			$("#tabela")
				.append($("<tr id="+item.id+">")
					.append($("<td>")
						.text(item.id))
					.append($("<td>")
						.text(item.remetente))
					.append($("<td>")
						.text(item.destinatario))
					.append($("<td>")
						.html(item.mensagem+"<a href=lista_anexo.php?despacho="+item.id+"&memorando="+<?php echo $id_memorando; ?>+" target=_self><img src=../img/clip.png heigh=30px width=30px></a>"))
					.append($("<td >")
						.text(item.data)));
		});
        $("#header").load("header.php");
        $(".menuu").load("menu.html");
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
    		top: 50%;
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
			float: left;
			color: #abb4be;
			font-weight: 550;
		}

		#link
		{
			background-color: #e6e5e5;
			border-radius: 0px;
			border: none;
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
								<a href="home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Despacho</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>
				<!-- start: page -->
				<section class="panel" >
					<header class="panel-heading">
						<h2 class="panel-title">Despacho</h2>
					</header>
					<div class="panel-body" >
						<div class="select" >
							<select class="select-table-filter form-control mb-md" data-table="order-table">
								<option selected disabled>Despacho</option>
							</select>float:right;"></h5>
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
							<h2 class="panel-title">Novo despacho</h2>
						</header>
						<div class="panel-body">
							<?php	
								echo "<form action=../memorando/inseredespacho.php?id=".$id_memorando." method=post>";
								echo "<label for=destinatario id=etiqueta_destinatario>Para </label>";
								echo "<select id=destinatario name=destinatario id=destinatario required class='select-table-filter form-control mb-md'>";
								$comando="select pessoa.nome, funcionario.id_funcionario from funcionario join pessoa where funcionario.id_funcionario=pessoa.id_pessoa";
								$query=mysqli_query($conexao, $comando);
								$linhas=mysqli_num_rows($query);
for($i=0; $i<$linhas; $i++)
{
$consulta = mysqli_fetch_row($query);
$nome=$consulta[0];
$id=$consulta[1];
echo "<option id='$id' value='$id' name='$id'>$nome</option>";
}
echo "</select>";
echo "<tr><td><input type='text' id='despacho' name='despacho' required placeholder='Mensagem' class='form-control'></td>";
echo "<input type='file' name='arquivo[]' id='arquivo' multiple>";
echo "<td><input type='submit' value='Novo despacho' name='enviar' id='enviar' class='mb-xs mt-xs mr-xs btn btn-default'></td></tr>";
echo "<span id='mostra_assunto'></span>";
echo "</form>";
}
?>
</div>
	<div id="arquivos" hidden>
		<!--header class="panel-heading"-->
		<header class="panel-heading" id="barra">
			<div class="row">
			<div class="col-md-6">
			<h2 class="panel-title col-md-6" id="titulo" style="margin: 15px 0 0 15px;">Arquivos</h2>
			</div>
			<div class="col-md-6">
			<button type="button" id="x" class='mb-xs mt-xs mr-xs btn btn-default'><img src="../img/x.png" width="15px" height="15px"></button>
			</div>
						</header>
		</div>
		<!--/header-->
	</div>
	</div>
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
	<?php
		if(isset($_SESSION["anexos"]))
			{
			$anexo=$_SESSION["anexos"];
	?>
			<script>
				$(function(){	
					$("#arquivos").show();
					var anexo=<?php echo $anexo ?>;
					$.each(anexo,function(i,item){
            			$("#arquivos")
                			.append("<button type='button' class='btn btn-primary btn-lg btn-block' id='link'><a href="+item.link+" target='_blank'>"+item.nome+"."+item.extensao+"</a></button>");
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
		unset($_SESSION["anexos"]);
	?>
	<script>                	
	</script>
	</body>
</html>