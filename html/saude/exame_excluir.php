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
require_once "exame.php";

extract($_GET);

$arquivo = new DocumentoAtendido($id_doc);
if (!$arquivo->getException()){
    $arquivo->delete();
    // $sql = "SELECT f.id_fundocs, f.`data`, docf.nome_docfuncional FROM funcionario_docs f JOIN funcionario_docfuncional docf ON f.id_docfuncional = docf.id_docfuncional WHERE id_funcionario = " . $_GET['id_funcionario'] . ";";
    
    $sql = "SELECT se.id_exame, se.arquivo_nome, ada.descricao, se.`data` FROM saude_exames se JOIN saude_exame_tipos ada ON se.id_exame_tipos = ada.id_exame_tipo WHERE id_fichamedica =" . $_GET['id_fichamedica'] . ";";
    $pdo = Conexao::connect();
    $docfuncional = $pdo->query($sql);
    $docfuncional = $docfuncional->fetchAll(PDO::FETCH_ASSOC);
    $docfuncional = json_encode($docfuncional);
    echo $docfuncional;
}else{
    echo $arquivo->getException();
}

die();

