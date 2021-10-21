<?php

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);
require_once '../../dao/Conexao.php';
$pdo = Conexao::connect();
$descricao = $_POST["parentesco"];

$pdo->query("INSERT INTO atendido_parentesco (parentesco) VALUES ('$descricao')");

die();