<?php
require_once 'Conexao.php';
$pdo = Conexao::connect();
$situacao = $_POST["situacao"];

$sql = "INSERT into situacao(situacoes) values(:situacao)";

try {
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':situacao', $situacao);
	$stmt->execute();
} catch (PDOException $e) {
	$e->getMessage();
}