<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$descricao = $_POST["tipo"];

	$sql = "INSERT into atendido_docs_atendidos(descricao) values('" .$descricao ."')";
	$pdo->query($sql);
?>