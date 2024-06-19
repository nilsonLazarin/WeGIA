<?php

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);
require_once '../../dao/Conexao.php';

$descricao = $_POST["descricao"];
$descricao = trim($descricao);

if (!$descricao || empty($descricao)) {
    http_response_code(400);
    echo 'A descrição de um novo tipo de parentesco não pode ser vazia!';
}

try {
    $pdo = Conexao::connect();
    $sql = "INSERT INTO atendido_parentesco (parentesco) VALUES (:descricao)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->execute();
} catch (PDOException $e) {
    echo 'Ocorreu um erro ao tentar adicionar o parentesco: ' . $e->getMessage();
}