<?php
require_once 'Conexao.php';

$situacao = trim($_POST["situacao"]);

if(!$situacao || empty($situacao)){
	http_response_code(400);
	exit('Erro, a descrição de uma nova situação não pode ser vazia.');
}

try {
	$sql = "INSERT into situacao(situacoes) values(:situacao)";
	$pdo = Conexao::connect();
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':situacao', $situacao);
	$stmt->execute();
} catch (PDOException $e) {
	echo 'Erro ao inserir uma nova situação no banco de dados: '.$e->getMessage();
}