<?php

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);


require_once "../../dao/Conexao.php";
$pdo = Conexao::connect();
$id_dependente = $_POST["id_dependente"];

$dependente = $pdo->query("SELECT *, par.descricao AS parentesco
FROM funcionario_dependentes fdep
LEFT JOIN pessoa p ON p.id_pessoa = fdep.id_pessoa
LEFT JOIN funcionario_dependente_parentesco par ON par.id_parentesco = fdep.id_parentesco
WHERE fdep.id_dependente = $id_dependente;");
$dependente = $dependente->fetchAll(PDO::FETCH_ASSOC);
$dependente = json_encode($dependente);

echo $dependente;

die();