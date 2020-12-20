<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$beneficios = $_POST["beneficios"];

	$sql = "INSERT into beneficios(descricao_beneficios) values('" .$beneficios ."')";
	$pdo->query($sql);
?>