<?php

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11);

require_once "../../dao/Conexao.php";
require_once "./Documento.php";

extract($_GET);

$arquivo = new DocumentoFuncionario($id_doc);
if (!$arquivo->getException()){

    $arquivo->delete();
    header("Location: ../profile_funcionario.php?id_funcionario=$id_funcionario");
}else{
    echo $arquivo->getException();
}

