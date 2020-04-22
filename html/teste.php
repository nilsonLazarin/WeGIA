<?php
		session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}

	include "../memorando/conexao.php";
$id_memorando=$_GET["desp"];
$arquivado=$_GET["arq"];

$comando1="update memorando set id_status_memorando='6' where id_memorando='$id_memorando'";
$query1=mysqli_query($conexao, $comando1);
$linhas1=mysqli_affected_rows($conexao);
$memorandos=array();

$comando="select pessoa.nome, despacho.texto, despacho.id_remetente, despacho.data, despacho.id_destinatario, despacho.arquivo from despacho join pessoa on despacho.id_remetente=pessoa.id_pessoa where id_memorando=".$id_memorando." order by despacho.data desc";
$query=mysqli_query($conexao, $comando);
$linhas=mysqli_num_rows($query);
for($i=0; $i<$linhas; $i++)
{
	//$arquivo=base64_decode($consulta[5]);

	//$baseImagem = base64_decode($consulta[5]);
	//$extensao =  pathinfo($baseImagem, PATHINFO_EXTENSION);
	

//var_dump(substr($imgBase64, 11, strpos($imgBase64, ';') - 11));  // Saída = gif

	$consulta=mysqli_fetch_row($query);
	$imgBase64 = "data:image/jpg;base64,".$consulta[5];
	$memorandos[$i]=array('remetente'=>$consulta[0], 'mensagem'=>$consulta[1], 'data'=>$consulta[3], 'destinatario'=>$consulta[4], 'arquivo'=>$imgBase64);
}
$memorando=json_encode($memorandos);
	
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "personalizacao_display.php";
	?>
<!doctype html>

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
		console.log(memorando);
		$.each(memorando,function(i,item){
			if(item.arquivo.length>22)
			{
				
			$("#tabela")
				.append($("<tr>")
					.append($("<td>")
						.text(item.remetente))
					.append($("<td>")
						.html(item.mensagem + "  <a href="+item.arquivo+">Arquivo</a>"))
					.append($("<td >")
						.text(item.data)));
			}
		else
			{
				$("#tabela")
				.append($("<tr>")
					.append($("<td>")
						.text(item.remetente))
					.append($("<td>")
						.html(item.mensagem))
					.append($("<td >")
						.text(item.data)));
			}
		});
	});
	$(function () {
        $("#header").load("header.php");
        $(".menuu").load("menu.html");
    });

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
		}-->
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
									<th>remetente</th>
									<th>despacho</th>
									<th>data</th
								</tr>
							</thead>
							<tbody id="tabela">
							</tbody>
						</table>
					</div>
							<?php
			if($arquivado!=1)
{
	
echo "<form action=inseredespacho.php?id=".$id_memorando." method=post>";
echo "<label for=destinatario id=etiqueta_destinatario>Para </label>";
echo "<select id=destinatario name=destinatario id=destinatario required>";
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
echo "<tr><td><input type='text' id='despacho' name='despacho' required placeholder='Mensagem'></td>";
echo "<td><input type='submit' value='Novo despacho' name='enviar' id='enviar'></td></tr>";
echo "<span id='mostra_assunto'></span>";
echo "</form>";
}
?>
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