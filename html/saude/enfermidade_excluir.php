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
require_once "enfermidade.php";

extract($_GET);

$en = new EnfermidadeSaude($id_doc);
if (!$en->getException()){
    $en->delete();
    
    $sql = "SELECT se.id_CID, se.data_diagnostico, se.status, stc.descricao FROM saude_enfermidades se JOIN saude_tabelacid stc ON se.id_CID = stc.id_CID WHERE status = 1 AND id_fichamedica =" . $_GET['id_fichamedica'] . ";";
    $pdo = Conexao::connect();
    $enfermidades = $pdo->query($sql);
    $enfermidades = $enfermidades->fetchAll(PDO::FETCH_ASSOC);
    $enfermidades = json_encode($enfermidades);
    echo $enfermidades;
}else{
    echo $en->getException();
}

die();

