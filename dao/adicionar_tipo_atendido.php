<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$descricao = $_POST["tipo"];

	$sql = "INSERT into atendido_tipo(descricao) values('" .$descricao ."')";
	$pdo->query($sql);
?>