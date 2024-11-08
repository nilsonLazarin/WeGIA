<?php
session_start();
if (!isset($_SESSION['usuario'])) {
	header("Location: ../index.php");
}

define("DEBUG", false);

$config_path = "config.php";
if (file_exists($config_path)) {
	require_once($config_path);
} else {
	while (true) {
		$config_path = "../" . $config_path;
		if (file_exists($config_path)) break;
	}
	require_once($config_path);
}
$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$id_pessoa = $_SESSION['id_pessoa'];
$stmt = mysqli_prepare($conexao, "SELECT id_cargo FROM funcionario WHERE id_pessoa = ?");
mysqli_stmt_bind_param($stmt, 'i', $id_pessoa);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
if (!is_null($resultado)) {
	$id_cargo = mysqli_fetch_array($resultado);
	if (!is_null($id_cargo)) {
		$id_cargo = $id_cargo['id_cargo'];
	}
	$resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=25");
	if (!is_bool($resultado) and mysqli_num_rows($resultado)) {
		$permissao = mysqli_fetch_array($resultado);
		if ($permissao['id_acao'] < 5) {
			$msg = "Você não tem as permissões necessárias para essa página.";
			header("Location: ./home.php?msg_c=$msg");
		}
		$permissao = $permissao['id_acao'];
	} else {
		$permissao = 1;
		$msg = "Você não tem as permissões necessárias para essa página.";
		header("Location: ./home.php?msg_c=$msg");
	}
} else {
	$permissao = 1;
	$msg = "Você não tem as permissões necessárias para essa página.";
	header("Location: ./home.php?msg_c=$msg");
}
// Adiciona a Função display_campo($nome_campo, $tipo_campo)
require_once "personalizacao_display.php";

require_once "../dao/Conexao.php";

function quickQuery($query, $column)
{
	$pdo = Conexao::connect();
	$res = $pdo->query($query);
	$res = $res->fetchAll(PDO::FETCH_ASSOC);
	return $res[0][$column];
}

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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
	<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="icon" href="<?php display_campo("Logo", 'file'); ?>" type="image/x-icon">

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

	<!-- javascript functions -->
	<script
		src="../Functions/onlyNumbers.js"></script>
	<script
		src="../Functions/onlyChars.js"></script>
	<script
		src="../Functions/mascara.js"></script>

	<!-- jquery functions -->
	<script>
		document.write('<a href="' + document.referrer + '"></a>');
	</script>

	<script type="text/javascript">
		$(function() {
			$("#header").load("header.php");
			$(".menuu").load("menu.php");
		});
	</script>

	<script>
		var homeIcon;
		// Antes do navegador imprimir a página
		window.onbeforeprint = function(event) {
			homeIcon = $('#home-icon').children();
			$('#home-icon').empty();
			$('#home-icon').append($('<span />').text("<?php display_campo("Titulo", "str"); ?>"));
		}

		// Depois do navegador imprimir ou cancelar a impressão da página
		window.onafterprint = function(event) {
			$('#home-icon').empty();
			$('#home-icon').append(homeIcon);
		};
	</script>

	<!-- javascript tab management script -->



</head>

<body>
	<section class="body">
		<div id="header" class="print-hide"></div>
		<!-- end: header -->
		<div class="inner-wrapper">
			<!-- start: sidebar -->
			<aside id="sidebar-left" class="sidebar-left menuu  print-hide"></aside>
			<!-- end: sidebar -->
			<section role="main" class="content-body">
				<header class="page-header print-hide">
					<h2>Geração de Relatório</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li id="home-icon">
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
					<div class="descricao">
						<p>
							<li>
                                <h3>Geração de Produto</h3>		
								
							</li>
						</p>
						<button style="float: right;" class="mb-xs mt-xs mr-xs btn btn-default print-button" onclick="window.print();">Imprimir</button>
					</div>

					<table class="table table-striped">
						<thead class="thead-dark">
						<tr>
								<th scope="col" width="11%">Produto</th>		
								<th scope="col" width="11%">Categoria</th>
								<th scope="col" width="11%">Unidade</th>
								<th scope="col" width="11%">Estoque</th>
								<th scope="col" width="11%">Almoxarifado</th>				
								<th scope="col" width="11%">Data de entrada</th>
								<th scope="col" width="11%">Data de saída</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$pdo = Conexao::connect();
							
							$idProduto = isset($_GET['id_produto']) ? $_GET['id_produto'] : null;
							$idAlmoxarifado = isset($_GET['id_almoxarifado']) ? $_GET['id_almoxarifado'] : null;
							
							if ($idProduto && $idAlmoxarifado) {
								$stmt = $pdo->prepare("
									SELECT 
										p.descricao AS produto_descricao, 
										a.descricao_almoxarifado, 
										e.data AS data_entrada, e.hora AS hora_entrada, 
										s.data AS data_saida, s.hora AS hora_saida,
										u.descricao_unidade,
										est.qtd,
										c.descricao_categoria  -- Novo campo adicionado
									FROM produto p
									JOIN ientrada ie ON p.id_produto = ie.id_produto
									JOIN entrada e ON ie.id_entrada = e.id_entrada
									JOIN isaida isd ON p.id_produto = isd.id_produto
									JOIN saida s ON isd.id_saida = s.id_saida
									JOIN almoxarifado a ON s.id_almoxarifado = a.id_almoxarifado
									JOIN unidade u ON p.id_unidade = u.id_unidade  -- JOIN com a tabela unidade
									JOIN estoque est ON p.id_produto = est.id_produto  -- JOIN com a tabela estoque
									JOIN categoria_produto c ON p.id_categoria_produto = c.id_categoria_produto  -- JOIN com a tabela categoria_produto
									WHERE p.id_produto = :id_produto AND a.id_almoxarifado = :id_almoxarifado
								");					
								$stmt->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
								$stmt->bindParam(':id_almoxarifado', $idAlmoxarifado, PDO::PARAM_INT);
							
								if ($stmt->execute()) {
									$row = $stmt->fetch(PDO::FETCH_ASSOC);
								
									if ($row) {
										echo "<tr>";
										echo "<td>" . htmlspecialchars($row['produto_descricao']) . "</td>"; 
										echo "<td>" . htmlspecialchars($row['descricao_categoria']) . "</td>";
										echo "<td>" . htmlspecialchars($row['descricao_unidade']) . "</td>";
										echo "<td>" . htmlspecialchars($row['qtd']) . "</td>";
										echo "<td>" . htmlspecialchars($row['descricao_almoxarifado']) . "</td>"; 
										echo "<td>" . date('d/m/Y', strtotime($row['data_entrada'])) . " " . date('H:i', strtotime($row['hora_entrada'])) . "</td>";
										echo "<td>" . date('d/m/Y', strtotime($row['data_saida'])) . " " . date('H:i', strtotime($row['hora_saida'])) . "</td>";
										echo "</tr>";
									} else {
										echo "<tr><td colspan='7' style='text-align: center; vertical-align: middle;'>Produto ou Almoxarifado não encontrado.</td></tr>";
									}
								} else {
									echo "<tr><td colspan='7'>Erro ao buscar os dados.</td></tr>";
								}													
							} else {
								echo "<tr><td colspan='4'>ID do produto ou almoxarifado não fornecido.</td></tr>";
							}
						?>
						</tbody>
					</table>
				</div>
				<!--end: page-->
			</section>
		</div>
	</section>
	<div align="right">
		<iframe src="https://www.wegia.org/software/footer/matPat.html" width="200" height="60" style="border:none;"></iframe>
	</div>
</body>
<script>
</script>

</html>