<?php

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

$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$id_pessoa = $_SESSION['id_pessoa'];
$resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
if(!is_null($resultado)){
	$id_cargo = mysqli_fetch_array($resultado);
	if(!is_null($id_cargo)){
		$id_cargo = $id_cargo['id_cargo'];
	}
	$resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=3");
	if(!is_bool($resultado) and mysqli_num_rows($resultado)){
		$permissao = mysqli_fetch_array($resultado);
		if($permissao['id_acao'] == 1){
        	$msg = "Você não tem as permissões necessárias para essa página.";
        	header("Location: ".WWW."html/home.php?msg_c=$msg");
		}
		$permissao = $permissao['id_acao'];
	}else{
        $permissao = 1;
        $msg = "Você não tem as permissões necessárias para essa página.";
        header("Location: ".WWW."html/home.php?msg_c=$msg");
	}	
}else{
	$permissao = 1;
    $msg = "Você não tem as permissões necessárias para essa página.";
    header("Location: ".WWW."html/home.php?msg_c=$msg");
}	

require_once ROOT."/controle/memorando/MemorandoControle.php";

$memorandos = new MemorandoControle;
$memorandos->listarTodosInativos();
	
// Adiciona a Função display_campo($nome_campo, $tipo_campo)
require_once ROOT."/html/personalizacao_display.php";
?>

<!DOCTYPE html>
<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Memorandos despachados</title>
		
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
	<script src="<?php echo WWW;?>Functions/enviar_dados.js"></script>
	<script src="<?php echo WWW;?>Functions/mascara.js"></script>

	<!-- printThis -->
    <script src="<?php echo WWW;?>assets/vendor/jasonday-printThis-f73ca19/printThis.js"></script>

		
	<!-- jquery functions -->

   	<script>
	$(function(){
		var memorando=<?php echo $_SESSION['memorandoInativo']?>;
		$.each(memorando,function(i,item){
			$("#tabela")
				.append($("<tr>")
					.append($("<td>")
						.text(item.id_memorando))
					.append($("<td id=titulo"+item.id_memorando+">")
						.html("<a href=<?php echo WWW;?>html/memorando/listar_despachos.php?id_memorando="+item.id_memorando+">"+item.titulo+"</a>"))
					.append($("<td>")
						.text(item.nome))
					.append($("<td>")
						.text(item.data.substr(8,2)+"/"+item.data.substr(5,2)+"/"+item.data.substr(0,4)+" "+item.data.substr(10))));

				if(item.id_status_memorando == 6)
				{
					$("#titulo"+item.id_memorando).append(" [ARQUIVADO]");
				}
		});
	
        $("#header").load("<?php echo WWW;?>html/header.php");
        $(".menuu").load("<?php echo WWW;?>html/menu.php");
    });
	</script>
	
	<style type="text/css">
		.select{
			position: absolute;
			width: 235px;
		}

		/* print styles*/
		@media print {
    		.printable {
        		display: block;
   			 }
   			.screen {
        		display: none;
    		}
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
					<h2>Memorandos despachados</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="<?php echo WWW;?>html/home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Memorandos despachados</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>
				<!-- start: page -->
				<div id="myModal">
					<header class="panel-heading">
						<h2 class="panel-title">
							<center> 
							<img src="<?php display_campo("Logo","file");?>" height="40" class="print-logo" style="margin-right: 700px;" /><p>
							WeGIA 
							<p> Web Gerenciador Institucional
						</center>

						</h2>
					</header>
					<div class="panel-body">
						<button style="margin-bottom: 0px !important;" class="not-printable mb-xs mt-xs mr-xs btn btn-default" id="btnPrint">Imprimir</button>
						<br>
	  					<br><br>
		  					
						<table class="table table-bordered table-striped mb-none" id="datatable-default">
							<thead>
								<tr>
									<th>Código</th>
									<th>Título</th>
									<th>Origem</th>
									<th>Data</th>
								</tr>
							</thead>
							<tbody id="tabela">
							</tbody>
						</table>
					</div>
				</div>
				<div class="printable"></div>
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
		 <script type="text/javascript">
            $(function(){
                $("#btnPrint").click(function () {
                    //get the modal box content and load it into the printable div
                    if((typeof(impressao) == "undefined") || impressao!=1)
                    {
                      $("#myModal a").removeAttr("href");
                        $(".printable").html($("#myModal").html());
                    }
                    $(".printable").printThis();
                    var impressao = 1;
                    $("#myModal").hide();
                }); 
            });
        </script>
	</body>
</html>