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
$nome_docfuncional = $_POST["nome_docfuncional"];

$nome_docfuncional = addslashes($nome_docfuncional);

$pdo->query("INSERT INTO funcionario_docfuncional (nome_docfuncional) VALUES ('$nome_docfuncional')");

die();