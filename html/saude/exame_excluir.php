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
$id_fichamedica = isset($_GET['id_fichamedica']) ? $_GET['id_fichamedica'] : null;

$arquivo = new ExameSaude($id_doc);
if (!$arquivo->getException()){
    $arquivo->delete();
    
    $sql = "SELECT se.id_exame, se.arquivo_nome, ada.descricao, se.`data` FROM saude_exames se JOIN saude_exame_tipos ada ON se.id_exame_tipos = ada.id_exame_tipo WHERE id_fichamedica = ?;";
    
    $pdo = Conexao::connect();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $id_fichamedica, PDO::PARAM_INT); // Bind do parâmetro
    $stmt->execute();
    
    $docfuncional = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $docfuncional = json_encode($docfuncional);

    echo $docfuncional;
    
}else{
    echo $arquivo->getException();
}

die();

