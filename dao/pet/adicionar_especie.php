<?php
require_once'../Conexao.php';
$pdo = Conexao::connect();
// $cargo = $_POST["nome_docfuncional"];
$especie = $_POST["especie"];

$sql = "INSERT INTO pet_especie(descricao) values('" .$especie ."')";
$pdo->query($sql);

?>