<?php
require_once 'Conexao.php';

$descricao = trim($_POST["tipo"]);

if(!$descricao || empty($descricao)){
	http_response_code(400);
	exit('Erro, a descrição de um novo tipo não poder ser vazia.');
}

try{
	$sql = "INSERT into atendido_tipo(descricao) values(:descricao)";
	$pdo = Conexao::connect();
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':descricao', $descricao);
	$stmt->execute();
}catch(PDOException $e){
	echo 'Erro ao inserir a descrição do novo tipo no banco de dados: '.$e->getMessage();
}