<?php
	require_once 'Conexao.php';
	$pdo = Conexao::connect();
	$beneficios = trim($_POST["beneficios"]);

	if(!$beneficios || empty($beneficios)){
		http_response_code(400);
		exit('Erro, a descrição fornecida para o benefício não pode ser vazia.');
	}

	try {
		$sql = "INSERT into beneficios(descricao_beneficios) values(:descricaoBeneficio)";
		$pdo = Conexao::connect();
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':descricaoBeneficio', $beneficios);
		$stmt->execute();
	} catch (PDOException $e) {
		echo 'Erro ao adicionar novo benefício: '.$e->getMessage();
	}
?>