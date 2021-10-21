<?php

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);

require_once "../../dao/Conexao.php";

$id_dependente = $_POST["id_dependente"];

try {
    $pdo = Conexao::connect();
    // $pdo->query("DELETE FROM funcionario_dependentes_docs WHERE id_dependente = $id_dependente;");
    $pdo->query("DELETE FROM funcionario_dependentes WHERE id_dependente = $id_dependente;");
    
    $response = $pdo->query("SELECT 
    af.idatendido_familiares AS id_dependente, p.nome AS nome, p.cpf AS cpf, ap.parentesco AS parentesco
    FROM atendido_familiares af
    LEFT JOIN atendido a ON a.atendido_idatendido = af.atendido_idatendido
    LEFT JOIN pessoa p ON p.id_pessoa = af.pessoa_id_pessoa
    LEFT JOIN atendido_parentesco ap ON ap.idatendido_parentesco = af.atendido_parentesco_idatendido_parentesco
    WHERE af.atendido_atendido = ".$_POST['id_funcionario']);
    $response = $response->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($response);
} catch (PDOException $th) {
    echo json_encode($th);
}

die();