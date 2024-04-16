<?php
require_once 'Conexao.php';
$pdo = Conexao::connect();
$cargo = $_POST["cargo"];

$sql = "INSERT into cargo(cargo) values(:cargo)";

try {
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':cargo', $cargo);
	$stmt->execute();
} catch (PDOException $e) {
	$e->getMessage();
}