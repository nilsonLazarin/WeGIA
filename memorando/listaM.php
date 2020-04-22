<?php
session_start();
if(!isset($_SESSION['usuario'])){
header ("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html class="fixed">

    <head>
        <title>Memorando</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Basic -->
	<meta charset="UTF-8">

<title>Home</title>

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

<!--Página Css que não interfere no estilo de oputras páginas do sistema-->
<link rel="stylesheet" href="../css/home-theme.css" />

<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="../assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
<link rel="stylesheet" href="../assets/vendor/morris/morris.css" />

<!-- Theme CSS -->
<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
<link rel="icon" href="../img/logofinal.png" type="image/x-icon">

<!-- Skin CSS -->
<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

<!-- Theme Custom CSS -->
<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

<!-- Head Libs -->
<script src="../assets/vendor/modernizr/modernizr.js"></script>
<script src="../Functions/lista.js"></script>
<!-- Vendor -->
<script src="../assets/vendor/jquery/jquery.min.js"></script>
    </head>

    <body>
    <section class="body">
    <div id="header">
    <header class="header">
	<div class="logo-container">
		<a href="home.php" class="logo">
			<img src="../img/logofinal.png" height="35" alt="Porto Admin" />
		</a>
		<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<!-- start: search & user box -->
	<div class="header-right">
		<span class="separator"></span>
		<div id="userbox" class="userbox">
			<a href="#" data-toggle="dropdown">
				<figure class="profile-picture">
					<img src="../img/semfoto.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="../assets/images/!logged-user.jpg" />
				</figure>
				<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
					<span class="name">Usuário</span>
					<span class="role">Funcionário</span>
				</div>
				<i class="fa custom-caret"></i>
			</a>
	
			<div class="dropdown-menu">
				<ul class="list-unstyled">
					<li class="divider"></li>
					<li>
						<a role="menuitem" tabindex="-1" href="../html/alterar_senha.php"><i class="glyphicon glyphicon-lock"></i> Alterar senha</a>
					</li>
					<li>
						<a role="menuitem" tabindex="-1" href="./logout.php"><i class="fa fa-power-off"></i> Sair da sessão</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end: search & user box -->
	</header>
	</div>
	<!-- end: search & user box -->
</header>
    </div>
    <!-- end: header -->
    <div class="inner-wrapper">
	            <!-- start: sidebar -->
	            <aside id="sidebar-left" class="sidebar-left menuu">

                <div class="sidebar-header">
		<div class="sidebar-title">
			Menu
		</div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>
	
	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					<li>
						<a href="../html/home.php">
							<i class="fa fa-home" aria-hidden="true"></i>
							<span>Início</span>
						</a>
					</li>
					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-copy"></i>
							<span>Pessoas</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="cadastro_funcionario.php">
									 Cadastrar Funcionário
								</a>
							</li>
							<li>
								<a href="cadastro_interno.php">
									 Cadastrar Atendido
								</a>
							</li>
							<!--<li>
								<a href="cadastro_voluntario.php">
									 Cadastrar voluntário
								</a>
							</li>
							<li>
								<a href="cadastro_voluntario_judicial.php">
									 Cadastrar voluntário judicial
								</a>
							</li>-->
							<li>
								<a href="../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php">
									 Informações Funcionários
								</a>
							</li>
							<li>
								<a href="../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=../html/informacao_interno.php">
									 Informações Atendido
								</a>
							</li>
						</ul>
					</li>

					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-copy" aria-hidden="true"></i>
							<span>Material e Patrimônio</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="../html/cadastro_entrada.php">
									 Cadastrar Produtos
								</a>
							</li>
							<li>
								<a href="../html/cadastro_saida.php">
									 Saida de Produtos
								</a>
							</li>
							<li>
								<a href="../html/estoque.php">
									 Estoque
								</a>
							</li>
							<li>
								<a href="../html/listar_almox.php">
									 Almoxarifados
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-cog" aria-hidden="true"></i>
							<span>Configurações</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="../html/personalizacao.php">
									Editar Conteúdos
								</a>
							</li>
							<li>
								<a href="../html/personalizacao_imagem.php">
									Lista de Imagens
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<form id="listarFuncionario" method="POST" action="../controle/control.php">
		<input type="hidden" name="nomeClasse" value="FuncionarioControle">
		<input type="hidden" name="metodo" value="listartodos">
		<input type="hidden" name="nextPage" value="../html/informacao_funcionario.php">
	</form>
	
	<form id="listarInterno" method="POST" action="../controle/control.php">
		<input type="hidden" name="nomeClasse" value="InternoControle">
		<input type="hidden" name="metodo" value="listartodos">
		<input type="hidden" name="nextPage" value="../html/informacao_interno.php">
	</form>
		
	<!-- Theme Base, Components and Settings -->
	<script src="../assets/javascripts/theme.js"></script>
		
	<!-- Theme Custom -->
	<script src="../assets/javascripts/theme.custom.js"></script>
	
	<!-- Theme Initialization Files -->
	<script src="../assets/javascripts/theme.init.js"></script>


                </aside>
				<!-- end: sidebar -->
				<section role="main" class="content-body">
				<header class="page-header">
					<h2>Home</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="./home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Início</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

<?php
include("conexao.php");
$id_memorando=$_GET["desp"];
$arquivado=$_GET["arq"];
?>
<table class="table table-bordered table-striped mb-none" id="datatable-default">
			<thead>
    			<tr>
				<th scope="col">Remetente</th>
      			<th scope="col">Despacho</th>
      			<th scope="col">Data</th>
    			</tr>
			  </thead>
			  <tbody id="tabela">
<?php

$memorandos=array();

$comando="select pessoa.nome, despacho.texto, despacho.id_remetente, despacho.data from despacho join pessoa where id_memorando=".$id_memorando." and despacho.id_remetente=pessoa.id_pessoa order by despacho.data desc";
$query=mysqli_query($conexao, $comando);
$linhas=mysqli_num_rows($query);
for($i=0; $i<$linhas; $i++)
{
	$consulta=mysqli_fetch_row($query);
	$memorandos[$i]=array('remetente'=>$consulta[0], 'mensagem'=>$consulta[1], 'data'=>$data[2]);
}
$memorando=json_encode($memorandos);
?>
<script>
	$(function(){
		var estoque=<?php echo $memorando?> ;
		console.log(estoque);

		$.each(estoque,function(i,item){
			$("#tabela")
				.append($("<tr>")
					.append($("<td>")
						.text(item.remetente))
					.append($("<td>")
						.text(item.mensagem))
					.append($("<td >")
						.text(item.data)));
		});
	});
	</script>
<?php
echo "</tbody>";
echo "</table>";
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