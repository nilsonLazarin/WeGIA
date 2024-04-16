<?php
require_once 'Conexao.php';
$pdo = Conexao::connect();
$nomeDocFuncional = $_POST["nome_docfuncional"];

$sql = "INSERT into funcionario_docfuncional(nome_docfuncional) values(:nomeDocFuncional)";

try {
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':nomeDocFuncional', $nomeDocFuncional);
	$stmt->execute();
} catch (PDOException $e) {
	$e->getMessage();
}
