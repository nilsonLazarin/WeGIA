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

$cep = ($cep ? "'$cep'" : "NULL");
$uf = ($uf ? "'$uf'" : "NULL");
$cidade = ($cidade ? "'$cidade'" : "NULL");
$bairro = ($bairro ? "'$bairro'" : "NULL");
$rua = ($rua ? "'$rua'" : "NULL");
$complemento = ($complemento ? "'$complemento'" : "NULL");
$ibge = ($ibge ? "'$ibge'" : "NULL");
$numero_residencia = ($numero_residencia ? "'$numero_residencia'" : "'Não possui'");

$sql = "UPDATE pessoa SET cep=$cep, estado=$uf, cidade=$cidade, bairro=$bairro, logradouro=$rua, complemento=$complemento, ibge=$ibge, numero_endereco=$numero_residencia WHERE id_pessoa=$id_pessoa;";

$pdo->query($sql);

$_GET['sql'] = $sql;
echo(json_encode($_GET));

?>
