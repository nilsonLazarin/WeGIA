<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);

require_once "../../dao/Conexao.php";
require_once "documento.php";

$id_doc = $_GET['id_doc'];
$idAtendido = $_GET['idatendido'];

if (!$id_doc || !$idAtendido || !is_numeric($id_doc) || !is_numeric($idAtendido)) {
    http_response_code(400);
    exit("Erro ao tentar remover o arquivo selecionado, os id's fornecidos não são válidos");
}

$arquivo = new DocumentoAtendido($id_doc);
if (!$arquivo->getException()) {
    $arquivo->delete();
    // $sql = "SELECT f.id_fundocs, f.`data`, docf.nome_docfuncional FROM funcionario_docs f JOIN funcionario_docfuncional docf ON f.id_docfuncional = docf.id_docfuncional WHERE id_funcionario = " . $_GET['id_funcionario'] . ";";
    try {
        $sql = "SELECT a.idatendido_documentacao, a.`data`, ada.descricao FROM atendido_documentacao a JOIN atendido_docs_atendidos ada ON a.atendido_docs_atendidos_idatendido_docs_atendidos = ada.idatendido_docs_atendidos WHERE atendido_idatendido =:idAtendido";
        $pdo = Conexao::connect();
        //$docfuncional = $pdo->query($sql);
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idAtendido', $idAtendido);
        $stmt->execute();
        $docfuncional = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $docfuncional = json_encode($docfuncional);
        echo $docfuncional;
    } catch (PDOException $e) {
        echo 'Erro ao tentar remover o arquivo selecionado: ' . $e->getMessage();
    }
} else {
    echo $arquivo->getException();
}