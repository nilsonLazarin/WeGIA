<?php
/*
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);
require_once '../../dao/Conexao.php';
try {
    $pdo = Conexao::connect();
    $descricao = $_POST["parentesco"];

    $stmt = $pdo->prepare("INSERT INTO atendido_parentesco (parentesco) VALUES ('$descricao')");
    $stmt->execute();
} catch (PDOException $e) {
    $e->getMessage();
}
die();*///Temporariamente desativado pois nenhum arquivo estava utilizando, avaliar possível remoção
