<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$descricao_epi = $_POST["descricao_epi"];

	$sql = "INSERT into epi(descricao_epi) values('" .$descricao_epi ."')";
	$pdo->query($sql);
?>