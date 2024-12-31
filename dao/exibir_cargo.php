<?php
require_once 'Conexao.php';
try {
	$pdo = Conexao::connect();

	$sql = 'SELECT * FROM cargo';
	$stmt = $pdo->query($sql);
	$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($resultado as $index => $cargo){
		$resultado[$index]['cargo'] = htmlspecialchars($cargo['cargo']);
	}

	echo json_encode($resultado);
} catch (PDOException $e) {
	http_response_code(500);
	echo 'Erro ao exibir cargos: '.$e->getMessage();
}
