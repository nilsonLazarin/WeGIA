<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from atendido_docs_atendidos ORDER BY descricao ASC;';
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('idatendido_docs_atendidos'=>$row['idatendido_docs_atendidos'],'descricao'=>$row['descricao']);
	}
	echo json_encode($resultado);
?>