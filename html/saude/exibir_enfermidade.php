<?php
	require_once'../../dao/Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from saude_tabelacid';
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('id_CID'=>$row['id_CID'],'descricao'=>$row['descricao']);
	}
	echo json_encode($resultado);
?>