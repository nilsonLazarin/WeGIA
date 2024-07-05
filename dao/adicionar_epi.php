<?php
require_once 'Conexao.php';

$descricao_epi = trim($_POST["descricao_epi"]);

if (!$descricao_epi || empty($descricao_epi)) {
	http_response_code(400);
	exit('Erro ao adicionar EPI: A descrição de um EPI não pode ser vazia.');
}

try {
	$pdo = Conexao::connect();
	$sql = "INSERT into epi(descricao_epi) values(:descricaoEpi)";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':descricaoEpi', $descricao_epi);
	$stmt->execute();
} catch (PDOException $e) {
	echo 'Erro ao adicionar EPI: '.$e->getMessage();
}
