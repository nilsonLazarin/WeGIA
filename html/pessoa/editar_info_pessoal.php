<?php

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 1, 3);

require_once "../../dao/Conexao.php";
$pdo = Conexao::connect();

extract($_POST);

$nome = ($nome ? "'$nome'" : "NULL");
$sobrenome = ($sobrenome ? "'$sobrenome'" : "NULL");
$telefone = ($telefone ? "'$telefone'" : "NULL");
$nome_pai = ($nome_pai ? "'$nome_pai'" : "NULL");
$nome_mae = ($nome_mae ? "'$nome_mae'" : "NULL");
$gender = ($gender ? "'$gender'" : "NULL");
$sanque = ($sanque ? "'$sanque'" : "NULL");
$nascimento = ($nascimento ? "'$nascimento'" : "NULL");

$sql = "UPDATE pessoa SET nome=$nome, sobrenome=$sobrenome, telefone=$telefone, sexo=$gender, nome_pai=$nome_pai, nome_mae=$nome_mae, data_nascimento=$nascimento, tipo_sanguineo=$sanque WHERE id_pessoa=$id_pessoa;";

$pdo->query($sql);


$_GET['sql'] = $sql;
echo(json_encode($_GET));