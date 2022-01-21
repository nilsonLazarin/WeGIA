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
require_once "descricaomedica.php";

extract($_GET);

$en = new DescricaoMedicaSaude($id_doc);
if (!$en->getException()){
    $en->delete();
    
    $sql = "SELECT id_atendimento, descricao FROM saude_atendimento WHERE id_fichamedica =" . $_GET['id_fichamedica'] . ";";
    $pdo = Conexao::connect();
    $desc = $pdo->query($sql);
    $desc = $desc->fetchAll(PDO::FETCH_ASSOC);
    $desc = json_encode($desc);
    echo $desc;
}else{
    echo $en->getException();
}

die();

