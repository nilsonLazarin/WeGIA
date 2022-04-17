<?php
	require_once '../../dao/Conexao.php';
	$pdo = Conexao::connect();
	//$situacao = $_POST["situacao"];
	$s1 = $_POST["cid"];
	$s2 = $_POST["nome"];
	$teste = explode(",", $situacao);

	$sql = "INSERT into saude_tabelacid(CID, descricao) values('$s1', '$s2')";
	$pdo->query($sql);
?>