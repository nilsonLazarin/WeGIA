<?php
	require_once '../../dao/Conexao.php';
	$pdo = Conexao::connect();
	$nome_docfuncional = $_POST["nome_docfuncional"];

	$pdo->query("INSERT INTO funcionario_docfuncional (nome_docfuncional) VALUES ('$nome_docfuncional')");
?>