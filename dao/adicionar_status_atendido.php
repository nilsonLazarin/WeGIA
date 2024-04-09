<?php
	require_once'Conexao.php';
	$pdo = Conexao::connect();
	$status = $_POST["status"];

	$sql = "INSERT into atendido_status(status) values(:status)";

	try{
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':status', $status);
		$stmt->execute();
	}catch(PDOException $e){
		$e->getMessage();
	}