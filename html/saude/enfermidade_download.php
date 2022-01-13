<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);

require_once "../../dao/Conexao.php";
require_once "enfermidade.php";

define("TYPEOF_EXTENSION", [
    'jpg' => 'image/jpg',
    'png' => 'image/png',
    'jpeg' => 'image/jpeg',
    'pdf' => 'application/pdf',
    'docx' => 'application/docx',
    'doc' => 'application/doc',
    'odp' => 'application/odp',
]);

$enfermidade = new EnfermidadeSaude($_GET["id_doc"]);

if (!$enfermidade->getException()){
    header("Content-type: ".TYPEOF_EXTENSION[$enfermidade->getExtensao()]);
    header("Content-Disposition: attachment; filename=".$enfermidade->getNome());
    ob_clean();
    flush();
    
    echo $enfermidade->getDocumento();
}else{
    echo $enfermidade->getException();
}

die();
