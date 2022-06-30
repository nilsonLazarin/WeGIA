<?php
require_once'../Conexao.php';
$pdo = Conexao::connect();
// $cargo = $_POST["nome_docfuncional"];
$raca = $_POST["raca"];

$sql = "INSERT INTO pet_raca(descricao) values('" .$raca ."')";
$pdo->query($sql);

?>