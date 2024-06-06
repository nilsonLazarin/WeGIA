<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);

require_once "../../dao/Conexao.php";
require_once "documento.php";

define("TYPEOF_EXTENSION", [
    'jpg' => 'image/jpg',
    'png' => 'image/png',
    'jpeg' => 'image/jpeg',
    'pdf' => 'application/pdf',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'doc' => 'application/doc',
    'odp' => 'application/odp',
]);

$idDoc = $_GET['id_doc'];
if(!is_numeric($idDoc) || $idDoc < 1){
    http_response_code(400);
    exit('Não foi possível baixar o documento solicitado.');
}

$arquivo = new DocumentoAtendido($idDoc);

if (!$arquivo->getException()){
    header("Content-type: ".TYPEOF_EXTENSION[$arquivo->getExtensao()]);
    header("Content-Disposition: attachment; filename=".$arquivo->getNome());
    ob_clean();
    flush();
    
    echo $arquivo->getDocumento();
}else{
    echo $arquivo->getException();
}