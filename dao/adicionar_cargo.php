<?php
require_once 'Conexao.php';

$cargo = trim($_POST["cargo"]);

if(!$cargo || empty($cargo)){
	http_response_code(400);
	exit('Erro, a descrição fornecida para o cargo não pode ser vazia.');
}

try {
	$sql = "INSERT into cargo(cargo) values(:cargo)";
	$pdo = Conexao::connect();
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':cargo', $cargo);
	$stmt->execute();
} catch (PDOException $e) {
	echo 'Erro ao adicionar novo cargo: '.$e->getMessage();
}