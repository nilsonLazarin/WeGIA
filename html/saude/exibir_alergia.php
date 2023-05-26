<?php
	require_once'../../dao/Conexao.php';
	$pdo = Conexao::connect();

	$sql = "select * from saude_tabelacid WHERE CID LIKE 'T78.4.%'";
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('id_CID'=>$row['id_CID'],'CID'=>$row['CID'],'descricao'=>$row['descricao']);
	}
	echo json_encode($resultado);
?>