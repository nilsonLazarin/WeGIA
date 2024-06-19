<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$cargo = trim($_POST['cargo']);

	$sql = "INSERT into cargo(cargo) values('" .$cargo ."')";
	$pdo->query($sql);
?>