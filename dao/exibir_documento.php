<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'SELECT * FROM `funcionario_docfuncional` ';
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('id_docfuncional'=>$row['id_docfuncional'],'nome_docfuncional'=>$row['nome_docfuncional']);
	}
	echo json_encode($resultado);
?>