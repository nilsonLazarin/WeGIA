<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from beneficios';
	$stmt = $pdo->query($sql);
	while ($row = $stmt->fetch()) {
    	echo $row['descricao_beneficios'].",";
	}
?>