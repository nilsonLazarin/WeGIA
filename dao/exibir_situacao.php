<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from situacao';
	$stmt = $pdo->query($sql);
	while ($row = $stmt->fetch()) {
    	echo $row['situacoes'].",";
	}
?>