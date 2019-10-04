<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from epi';
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('id_epi'=>$row['id_epi'],'descricao_epi'=>$row['descricao_epi']);
	}
	echo json_encode($resultado);
?>