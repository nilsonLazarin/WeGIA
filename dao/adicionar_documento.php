<?php
require_once 'Conexao.php';

$nomeDocFuncional = trim($_POST["nome_docfuncional"]);

if(!$nomeDocFuncional || empty($nomeDocFuncional)){
	http_response_code(400);
	exit('Erro, o nome de um novo tipo de documento não pode ser vazio.');
}

try {
	$sql = "INSERT into funcionario_docfuncional(nome_docfuncional) values(:nomeDocFuncional)";
	$pdo = Conexao::connect();
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':nomeDocFuncional', $nomeDocFuncional);
	$stmt->execute();
} catch (PDOException $e) {
	echo 'Erro ao inserir um novo tipo de documento no banco de dados: '.$e->getMessage();
}
