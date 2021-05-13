<?php

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);


require_once "../../dao/Conexao.php";
$pdo = Conexao::connect();
extract($_POST);
$id_doc = $_POST["id_doc"] ?? null;
$action = $_POST["action"] ?? null;
$g_id_doc = $_GET["id_doc"] ?? null;
$g_action = $_GET["action"] ?? null;


define("TYPEOF_EXTENSION", [
    'jpg' => 'image/jpg',
    'png' => 'image/png',
    'jpeg' => 'image/jpeg',
    'pdf' => 'application/pdf',
    'docx' => 'application/docx',
    'doc' => 'application/doc',
    'odp' => 'application/odp',
]);

if ($action == "download" || $g_action == "download"){
    $sql = "SELECT extensao_arquivo, nome_arquivo, UNCOMPRESS(arquivo) AS arquivo FROM funcionario_dependentes_docs WHERE id_doc=$g_id_doc;";
    try {
        $docdependente = $pdo->query($sql);
        $docdependente = $docdependente->fetch(PDO::FETCH_ASSOC);
        header("Content-type: ".TYPEOF_EXTENSION[$docdependente["extensao_arquivo"]]);
        header("Content-Disposition: attachment; filename=".$docdependente["nome_arquivo"]);
        ob_clean();
        flush();
        echo base64_decode($docdependente["arquivo"]);
    } catch (PDOException $th) {
        echo "[{'exception': ['$th'], 'action': ['post': '$action', 'get': '$g_action'], 'id_doc': ['post': '$id_doc', 'get': '$g_id_doc']}]";
    }
}else if ($action == "excluir" || $g_action == "excluir"){
    $sql = [
        "DELETE FROM funcionario_dependentes_docs WHERE id_doc=$id_doc;",
        "SELECT doc.nome_docdependente AS descricao, ddoc.data, ddoc.id_doc FROM funcionario_dependentes_docs ddoc LEFT JOIN funcionario_docdependentes doc ON doc.id_docdependentes = ddoc.id_docdependentes WHERE ddoc.id_dependente=$id_dependente;"
    ];
    try {
        $pdo->query($sql[0]);
        $docdependente = $pdo->query($sql[1]);
        $docdependente = $docdependente->fetchAll(PDO::FETCH_ASSOC);
        $docdependente = json_encode($docdependente);
        echo $docdependente;
    } catch (PDOException $th) {
        echo "[{'exception': ['$th'], 'action': ['post': '$action', 'get': '$g_action'], 'id_doc': ['post': '$id_doc', 'get': '$g_id_doc']}]";
    }
}else if ($action = "adicionar" || $g_action == "adicionar"){
    $sql = [
        "INSERT INTO funcionario_docdependentes (nome_docdependente) VALUES (:n);",
        "SELECT * FROM funcionario_docdependentes;"
    ];
    try {
        $prep = $pdo->prepare($sql[0]);
        $prep->bindValue(":n", $nome);
        $prep->execute();
        $query = $pdo->query($sql[1]);
        $docdependente = $query->fetchAll(PDO::FETCH_ASSOC);
        $docdependente = json_encode($docdependente);
        echo $docdependente;
    } catch (PDOException $th) {
        echo "[{'exception': ['$th'], 'action': ['post': '$action', 'get': '$g_action'], 'id_doc': ['post': '$id_doc', 'get': '$g_id_doc']}]";
    }
}

die();