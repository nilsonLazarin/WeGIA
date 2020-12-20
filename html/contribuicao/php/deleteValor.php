<?php

require_once('conexao.php');
$query = new Conexao;

$idValor = $_GET['idValor'];
$idSistema = $_GET['idSistema'];

$query->query("DELETE FROM doacao_cartao_mensal WHERE id = '$idValor' AND id_sistema = '$idSistema'");

header("Location: configuracao_doacao.php");

?>