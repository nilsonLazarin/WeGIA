<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);

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
                                <h2>Geração de Produto</h2>		
							</li>
						</p>
						<button style="float: right;" class="mb-xs mt-xs mr-xs btn btn-default print-button" onclick="window.print();">Imprimir</button>
					</div>

					<?php
					$pdo = Conexao::connect();

					if($_SERVER["REQUEST_METHOD"] == "POST"){
						$idAlmoxarifado = isset($_POST['almoxarifado']) ? $_POST['almoxarifado'] : null;
						$idProduto = isset($_POST['produto']) ? $_POST['produto'] : null;
						
						$dataInicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : null;
						$dataFim = isset($_POST['data_fim']) ? $_POST['data_fim'] : null;

						$modeloBrasileiro = 'd/m/Y';
						$dataInicioFormatada = date_format(date_create($dataInicio), $modeloBrasileiro);
						$dataFimFormatada = date_format(date_create($dataFim), $modeloBrasileiro);

						if ($idProduto && $idAlmoxarifado) {
							$stmt = $pdo->prepare("
								SELECT 
									ientrada.id_entrada,
									entrada.data AS data_entrada,
									entrada.hora AS hora_entrada,
									almoxarifado.descricao_almoxarifado,
									produto.descricao,
									categoria_produto.descricao_categoria,
									ientrada.qtd AS quantidade_entrada,
									isaida.id_saida,
									saida.data AS data_saida,
									saida.hora AS hora_saida,
									isaida.qtd AS quantidade_saida,
									tipo_entrada.descricao AS descricao_tipo_entrada,
									tipo_saida.descricao AS descricao_tipo_saida,
									estoque.qtd AS estoque_atual,  -- Estoque atual da tabela estoque
									entrada.id_entrada AS id_entrada,  -- Adicionando id_entrada
									saida.id_saida AS id_saida  -- Adicionando id_saida
								FROM 
									ientrada
								JOIN 
									entrada ON ientrada.id_entrada = entrada.id_entrada
								JOIN 
									almoxarifado ON entrada.id_almoxarifado = almoxarifado.id_almoxarifado
								JOIN 
									produto ON ientrada.id_produto = produto.id_produto
								LEFT JOIN 
									categoria_produto ON produto.id_categoria_produto = categoria_produto.id_categoria_produto
								LEFT JOIN 
									isaida ON isaida.id_produto = ientrada.id_produto
								LEFT JOIN 
									saida ON isaida.id_saida = saida.id_saida
								LEFT JOIN 
									tipo_entrada ON entrada.id_tipo = tipo_entrada.id_tipo
								LEFT JOIN 
									tipo_saida ON saida.id_tipo = tipo_saida.id_tipo
								LEFT JOIN
									estoque ON estoque.id_produto = produto.id_produto 
									AND estoque.id_almoxarifado = almoxarifado.id_almoxarifado
								WHERE 
									almoxarifado.id_almoxarifado = :idAlmoxarifado
									AND produto.id_produto = :idProduto
						");
	
	
							$stmt->bindParam(':idProduto', $idProduto, PDO::PARAM_INT);
							$stmt->bindParam(':idAlmoxarifado', $idAlmoxarifado, PDO::PARAM_INT);
	
							$stmt->execute();
	
							$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
						}
					}
					?>

					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th scope="col" colspan="4" style="font-size: large;">INFORMAÇÕES DO PRODUTO</th>        
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>PRODUTO: <?php echo !empty($resultado['descricao']) ? htmlspecialchars($resultado['descricao']) : 'Não registrado'; ?></td>        
							</tr>
							<tr>
								<td>ALMOXARIFADO: <?php echo !empty($resultado['descricao_almoxarifado']) ? htmlspecialchars($resultado['descricao_almoxarifado']) : 'Não registrado'; ?></td>
							</tr>
							<tr>
								<td>CATEGORIA: <?php echo !empty($resultado['descricao_categoria']) ? htmlspecialchars($resultado['descricao_categoria']) : 'Não registrado'; ?></td>
							</tr>    
							<tr>
								<td>ESTOQUE ATUAL: <?php echo !empty($resultado['estoque_atual']) ? htmlspecialchars($resultado['estoque_atual']) : 'Não registrado'; ?></td>
							</tr>    
							<tr>
								<td>PERÍODO DO RELATÓRIO: <?php echo !empty($dataInicioFormatada) && !empty($dataFimFormatada) ? "<br> A partir de: " . $dataInicioFormatada . "<br>" . "Até: " . $dataFimFormatada : 'Não registrado'; ?></td>
							</tr>
						</tbody>
					</table>


					<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th scope="col" colspan="4" style="font-size: large;">ENTRADAS</th>
						</tr>
						<tr>
							<th scope="col" style="font-weight: 600;">DATA</th>
							<th scope="col" style="font-weight: 600;">CÓDIGO</th>
							<th scope="col" style="font-weight: 600;">TIPO</th>
							<th scope="col" style="font-weight: 600;">QTD</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php 
								$dataEntrada = date('d/m/Y H:i', strtotime($resultado['data_entrada'] . ' ' . $resultado['hora_entrada'])); 
								echo "<td>" . $dataEntrada . "</td>"; 
							?>
							<td><?php echo htmlspecialchars(trim($resultado['id_entrada'])); ?></td> 
							<td><?php echo htmlspecialchars(trim($resultado['descricao_tipo_entrada'])); ?></td> 
							<td><?php echo htmlspecialchars(trim($resultado['quantidade_entrada'])); ?></td> 
						</tr>
					</tbody>
				</table>

				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th scope="col" colspan="4" style="font-size: large;">SAÍDAS</th>
						</tr>
						<tr>
							<th scope="col" style="font-weight: 600;">DATA</th>
							<th scope="col" style="font-weight: 600;">CÓDIGO</th>
							<th scope="col" style="font-weight: 600;">TIPO</th>
							<th scope="col" style="font-weight: 600;">QTD</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php 
								$dataSaida = date('d/m/Y H:i', strtotime($resultado['data_saida'] . ' ' . $resultado['hora_saida'])); 
								echo "<td>" . $dataSaida . "</td>";
							?>
							<td><?php echo !empty($resultado['id_saida']) ? htmlspecialchars(trim($resultado['id_saida'])) : 'Não registrado'; ?></td> 
							<td><?php echo !empty($resultado['descricao_tipo_saida']) ? htmlspecialchars(trim($resultado['descricao_tipo_saida'])) : 'Não registrado'; ?></td> 
							<td><?php echo !empty($resultado['quantidade_saida']) ? htmlspecialchars(trim($resultado['quantidade_saida'])) : 'Não registrado'; ?></td> 
						</tr>
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