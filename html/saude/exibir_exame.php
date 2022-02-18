<?php
	require_once'../../dao/Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from saude_exame_tipos';
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('id_exame_tipo'=>$row['id_exame_tipo'],'descricao'=>$row['descricao']);
	}
	echo json_encode($resultado);
?>