<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from cargo';
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('id_cargo'=>$row['id_cargo'],'cargo'=>$row['cargo']);
	}
	echo json_encode($resultado);
?>