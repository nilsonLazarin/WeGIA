<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$status = $_POST["status"];

	$sql = "INSERT into atendido_status(status) values('" .$status ."')";
	$pdo->query($sql);
?>