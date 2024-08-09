<?php

require_once('conexao.php');

use Versao\Conexao;

$banco = new Conexao();

$idValor = $_GET['idValor'];
$idSistema = $_GET['idSistema'];

$query->query("DELETE FROM doacao_cartao_mensal WHERE id = '$idValor' AND id_sistema = '$idSistema'");

header("Location: configuracao_doacao.php");

?>