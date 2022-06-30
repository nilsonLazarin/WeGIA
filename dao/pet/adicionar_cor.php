<?php
require_once'../Conexao.php';
$pdo = Conexao::connect();
// $cargo = $_POST["nome_docfuncional"];
$cor = $_POST["cor"];

$sql = "INSERT INTO pet_cor(descricao) values('" .$cor ."')";
$pdo->query($sql);

?>