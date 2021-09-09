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
extract($_REQUEST);

if ($action == "adicionar_descricao"){
    $sql = "INSERT INTO funcionario_listainfo (descricao) VALUES ( '".addslashes($descricao)."' )";
    $response_query = "SELECT * FROM funcionario_listainfo;";
    try {
        $pdo->query($sql);
        echo json_encode($pdo->query($response_query)->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

if ($action == "adicionar"){
    $sql = "INSERT INTO funcionario_outrasinfo VALUES ( default , $id_funcionario , $id_descricao , '".addslashes($dados)."' )";
    try {
        $pdo->query($sql);
        listar();
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

if ($action == "remover"){
    $sql = "DELETE FROM funcionario_outrasinfo WHERE idfunncionario_outrasinfo = $id_descricao;";
    try {
        $pdo->query($sql);
        listar();
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

if ($action == "idInfoAdicional"){
    $sql = "SELECT max(idfunncionario_outrasinfo) FROM funcionario_outrasinfo;";
    try {
        $pdo->query($sql);
        echo json_encode($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC));
        listar();
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

if ($action == "listar"){
    listar();
}

function listar(){
    $response_query = "SELECT * FROM funcionario_outrasinfo o JOIN funcionario_listainfo l ON o.funcionario_listainfo_idfuncionario_listainfo = l.idfuncionario_listainfo;";
    try {
        echo json_encode($pdo->query($response_query)->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

die();