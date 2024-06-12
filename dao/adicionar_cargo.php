<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$cargo = mysqli_real_escape_string($conexao, $_POST['cargo']);

	$sql = "INSERT into cargo(cargo) values('" .$cargo ."')";
	$pdo->query($sql);
?>