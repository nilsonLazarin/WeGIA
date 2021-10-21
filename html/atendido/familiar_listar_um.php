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

$dependente = $pdo->query("SELECT *, ap.parentesco AS parentesco
FROM atendido_familiares af
LEFT JOIN pessoa p ON p.id_pessoa = af.pessoa_id_pessoa
LEFT JOIN atendido_parentesco ap ON ap.idatendido_parentesco = af.atendido_parentesco_idatendido_parentesco
WHERE af.idatendido_familiares= $id_dependente;");
$dependente = $dependente->fetchAll(PDO::FETCH_ASSOC)[0];
$dependente = json_encode($dependente);

echo $dependente;

die();