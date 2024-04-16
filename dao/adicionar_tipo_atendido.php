<?php
require_once 'Conexao.php';
$pdo = Conexao::connect();
$descricao = $_POST["tipo"];

$sql = "INSERT into atendido_tipo(descricao) values(:descricao)";

try{
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':descricao', $descricao);
	$stmt->execute();
}catch(PDOException $e){
	$e->getMessage();
}