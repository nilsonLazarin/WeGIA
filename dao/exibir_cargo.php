<?php
require_once 'Conexao.php';
try {
	$pdo = Conexao::connect();

	$sql = 'SELECT * FROM cargo';
	$stmt = $pdo->query($sql);
	$cargos = array();
	$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($resultado) {
		$resultado['cargo'] = htmlspecialchars($resultado['cargo']);
		$cargos = $resultado;
	}

	echo json_encode($cargos);
} catch (PDOException $e) {
	echo 'Erro ao exibir cargos: '.$e->getMessage();
}
