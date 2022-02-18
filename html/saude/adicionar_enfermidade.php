<?php
	require_once '../../dao/Conexao.php';
	$pdo = Conexao::connect();
	$situacao = $_POST["situacao"];

	$sql = "INSERT into saude_tabelacid(descricao) values('" .$situacao ."')";
	$pdo->query($sql);
?>