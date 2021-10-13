<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();

if (!isset($_SESSION["usuario"])){
    header("Location: ../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);

require_once "../../dao/Conexao.php";
require_once "documento.php";

extract($_GET);

$arquivo = new DocumentoAtendido($id_doc);
if (!$arquivo->getException()){
    $arquivo->delete();
    // $sql = "SELECT f.id_fundocs, f.`data`, docf.nome_docfuncional FROM funcionario_docs f JOIN funcionario_docfuncional docf ON f.id_docfuncional = docf.id_docfuncional WHERE id_funcionario = " . $_GET['id_funcionario'] . ";";
    
    $sql = "SELECT a.idatendido_documentacao, a.`data`, ada.descricao FROM atendido_documentacao a JOIN atendido_docs_atendidos ada ON a.atendido_docs_atendidos_idatendido_docs_atendidos = ada.idatendido_docs_atendidos WHERE atendido_idatendido =" . $_GET['idatendido'] . ";";
    $pdo = Conexao::connect();
    $docfuncional = $pdo->query($sql);
    $docfuncional = $docfuncional->fetchAll(PDO::FETCH_ASSOC);
    $docfuncional = json_encode($docfuncional);
    echo $docfuncional;
}else{
    echo $arquivo->getException();
}

die();

