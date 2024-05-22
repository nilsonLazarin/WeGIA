<?php
	require_once '../../dao/Conexao.php';
	
	$situacao = $_POST["situacao"];
	$situacao = trim($situacao);

	if(!$situacao){
		echo "O nome do novo tipo de exame não pode ser vazio!";
		exit(400);
	}

	try{
		$pdo = Conexao::connect();
		$sql = "INSERT into saude_exame_tipos(descricao) values(:situacao)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':situacao', $situacao);
		$stmt->execute();
	}catch(PDOException $e){
		"Ocorreu um erro ao cadastrar um novo tipo de exame: ".$e->getMessage();
	}
	
?>