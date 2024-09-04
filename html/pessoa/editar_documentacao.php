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

$rg = ($rg ? "'$rg'" : "NULL");
$orgao_emissor = ($orgao_emissor ? "'$orgao_emissor'" : "NULL");
$data_expedicao = ($data_expedicao ? "'$data_expedicao'" : "NULL");
$cpf = ($cpf ? "'$cpf'" : "NULL");

$sql = "UPDATE pessoa SET registro_geral = :rg, orgao_emissor = :orgao_emissor, data_expedicao = :data_expedicao, cpf = :cpf WHERE id_pessoa = :id_pessoa";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':rg', $rg);
$stmt->bindParam(':orgao_emissor', $orgao_emissor);
$stmt->bindParam(':data_expedicao', $data_expedicao);
$stmt->bindParam(':cpf', $cpf);
$stmt->bindParam(':id_pessoa', $id_pessoa);

$stmt->execute();

$_GET['sql'] = $sql;
echo(json_encode($_GET));