<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from cargo';
	$stmt = $pdo->query($sql);
	while ($row = $stmt->fetch()) {
    	echo $row['cargo'].",";
	}
?>