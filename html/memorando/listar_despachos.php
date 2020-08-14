<?php

/*ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);*/

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
        	header("Location: ".WWW."/html/home.php?msg_c=$msg");
		}
		$permissao = $permissao['id_acao'];
	}else{
        $permissao = 1;
        $msg = "Você não tem as permissões necessárias para essa página.";
        header("Location: ".WWW."/html/home.php?msg_c=$msg");
	}	
}else{
	$permissao = 1;
    $msg = "Você não tem as permissões necessárias para essa página.";
    header("Location: ".WWW."/html/home.php?msg_c=$msg");
}	

require_once ROOT."/controle/memorando/DespachoControle.php";
require_once ROOT."/controle/FuncionarioControle.php";
require_once ROOT."/controle/memorando/MemorandoControle.php";
require_once ROOT."/controle/memorando/AnexoControle.php";


$id_memorando=$_GET['id_memorando'];

$despachos = new DespachoControle;
$despachos->listarTodos();

$despachos2 = new DespachoControle;
$despachos2->listarTodosComAnexo();

$funcionarios = new FuncionarioControle;
$funcionarios->listarTodos2();

$ultimoDespacho =  new MemorandoControle;
$ultimoDespacho->buscarUltimoDespacho($id_memorando);

$Anexos = new AnexoControle;
$Anexos->listarTodos($id_memorando);

$id_status = new MemorandoControle;
$id_status->buscarIdStatusMemorando($id_memorando);

$memorandosDespachados = new MemorandoControle;
$memorandosDespachados->listarIdTodosInativos();
	
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

    <!-- jkeditor -->
    <script src="<?php echo WWW;?>assets/vendor/ckeditor/ckeditor.js"></script>
        
    <!-- jquery functions -->

   	<script>
	$(function(){
		var despacho=<?php echo $_SESSION['despacho']?>;
		var despachoAnexo=<?php echo $_SESSION['despachoComAnexo']?>;
		var arquivo = <?php echo $_SESSION['arquivos']?>;
		<?php
		if(!empty($_SESSION['ultimo_despacho']))
		{
			if($_SESSION['id_status_memorando'][0]!=6 && $_SESSION['ultimo_despacho'][0]['id_destinatarioo']!=$_SESSION['id_pessoa'])
			{
				?>var arquivar = 1;<?php
			}
			else
			{
				?>var arquivar = 0;<?php
			}
		}
		?>
		$.each(despacho,function(i,item){
			$("#listaDeDespachos")
				.append($("<table class='table table-bordered table-striped mb-none' id='"+item.id+"'>")
					.append($("<tr>")
						.append($("<th>")
							.text("Remetente"))
						.append($("<td>")
							.text(item.remetente))
						.append($("<th>")
							.text("Destinatario"))
						.append($("<td>")
							.text(item.destinatario)))
					.append($("<tr>")
						.append($("<th colspan=2>")
							.text("Despacho"))
						.append($("<th>")
							.text("Data"))
						.append($("<td>")
							.text(item.data.substr(8,2)+"/"+item.data.substr(5,2)+"/"+item.data.substr(0,4)+" "+item.data.substr(10))))
					.append($("<tr>")
						.append($("<td colspan=4 id=texto"+item.id+">")
							.html(item.texto))));
		});
		$.each(despachoAnexo,function(i, item){
			$("#"+item.id_despacho)
				.append($("<tr>")
						.append($("<th colspan=4>")
							.text("Anexos")));
		});
		$.each(arquivo, function(i, item){
			$("#"+item.id_despacho)
				.append($("<tr id=link>")
						.append($("<td colspan=4>")
							.html("<a href='<?php echo WWW;?>html/memorando/exibe_anexo.php?id_anexo="+item.id_anexo+"&extensao="+item.extensao+"&nome="+item.nome+"'>"+item.nome+"."+item.extensao+"</a>")));
		});

        $("#header").load("<?php echo WWW;?>html/header.php");
        $(".menuu").load("<?php echo WWW;?>html/menu.php");

        var id_memorando = <?php echo $_GET['id_memorando']?>;
        $("#id_memorando").val(id_memorando);

        <?php if(!empty($_SESSION['ultimo_despacho']))
		{ ?>
        if(arquivar==0)
        {
        CKEDITOR.replace('despacho');
   		}
    	<?php } ?>
    	
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

		#link
		{
			border-radius: 0px;
			border: none;
			color: #000000 !important;
		}
		#link:hover
		{
			background-color: #e6e5e5;
		}

		.panel-body
		{
			margin-bottom: 15px;
		}

		input[type="file"] {
			margin-bottom: 10px;
			margin-top: 15px;
		}

		.col-md-3 {
    		width: 10%;
		}

		#despacho
		{
			height: 500px;
		}

		#div_texto
        {
            width: 100%;
        }

        #cke_despacho
        {
        	height: 500px;
        }

        .cke_contents
        {
        	height: 500px;
        }

        #cke_1_contents
        {
        	height: 455px !important;
        }

        .table.mb-none
        {
        	margin-bottom: 25px !important; 
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
				if(!in_array($id_memorando, $_SESSION['memorandoIdInativo']))
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
					<div class="panel-body" id="listaDeDespachos">
						<div class="select" >
							<select class="select-table-filter form-control mb-md" data-table="order-table">
								<option selected disabled>Despacho</option>
							</select float:right;></h5>
	  					</div>
	  					<button style="float: right;" class="mb-xs mt-xs mr-xs btn btn-default">Imprimir</button>
	  					<br><br>
					</div>							
					<?php
						if($_SESSION['id_status_memorando'][0]!=6)
						{ 
							if($_SESSION['ultimo_despacho'][0]['id_destinatarioo']==$_SESSION['id_pessoa'])
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
												<select id=destinatario name=destinatario required class=' form-control mb-md'></select>
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
											<div class='col-md-6' id='div_texto' style="height: 500px;">							<textarea cols='30' rows='5' id='despacho' name='texto' required class='form-control'></textarea>
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
}
}?>
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
		}
		unset($_SESSION["arquivos"]);
	?>
	<script>
		$(function(){
		var funcionario=<?php echo $_SESSION['funcionarios2']?>;
    		$.each(funcionario,function(i,item){	
			$("#destinatario")
				.append($("<option id="+item.id_pessoa+" value="+item.id_pessoa+" name="+item.id_pessoa+">"+item.nome+" "+item.sobrenome+"</option>"));
		});    
		});           	
	</script>
	</body>
</html>