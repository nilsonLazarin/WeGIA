<?php
	require_once 'Conexao.php';
	
	$status = trim($_POST["status"]);

	if(!$status || empty($status)){
		http_response_code(400);
		exit('Erro, a descrição de um novo tipo de status não pode ser vazia.');
	}

	try{
		$pdo = Conexao::connect();
		$sql = "INSERT into atendido_status(status) values(:status)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':status', $status);
		$stmt->execute();
	}catch(PDOException $e){
		echo 'Erro ao inserir novo tipo de status no banco de dados: '.$e->getMessage();
	}