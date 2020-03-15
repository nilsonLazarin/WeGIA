<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$situacao = $_POST["situacao"];

	$sql = "INSERT into situacao(situacoes) values('" .$situacao ."')";
	$pdo->query($sql);
?>