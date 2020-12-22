<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from situacao';
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('id_situacao'=>$row['id_situacao'],'situacoes'=>$row['situacoes']);
	}
	echo json_encode($resultado);
?>