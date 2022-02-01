<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$cargo = $_POST["nome_docfuncional"];

	$sql = "INSERT into funcionario_docfuncional(nome_docfuncional) values('" .$cargo ."')";
	$pdo->query($sql);
?>