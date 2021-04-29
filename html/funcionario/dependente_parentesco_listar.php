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
$parentesco = $pdo->query("SELECT * FROM funcionario_dependente_parentesco ORDER BY descricao ASC;");
$parentesco = $parentesco->fetchAll(PDO::FETCH_ASSOC);
$parentesco = json_encode($parentesco);
echo $parentesco;