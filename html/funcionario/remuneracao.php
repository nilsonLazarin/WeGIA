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

if ($action == "tipo_adicionar"){
    $descricao = addslashes($descricao);
    $query = "SELECT * FROM funcionario_remuneracao_tipo WHERE descricao = '$descricao'";
    $sql = "INSERT INTO funcionario_remuneracao_tipo VALUES (default , :descricao)";
    try {
        $query = $pdo->query($query);
        $query = $query->fetch(PDO::FETCH_ASSOC);
        if ($query){
            echo '{"aviso": true, "msg": "Tipo de remuneração já existe!"}';
            die();
        }
        $prep = $pdo->prepare($sql);
        $prep->bindValue(":descricao", $descricao);
        $prep->execute();
        $response = $pdo->query("SELECT idfuncionario_remuneracao_tipo as id, descricao FROM funcionario_remuneracao_tipo;");
        echo json_encode($response->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $th) {
        echo json_encode($th);
    }
    die();
}

if ($action == "remuneracao_adicionar"){
    $inicio = $_POST["inicio"] ? "'".$_POST["inicio"]."'" : "NULL";
    $fim = $_POST["fim"] ? "'".$_POST["fim"]."'" : "NULL";
    $sql = "INSERT INTO funcionario_remuneracao VALUES (default , $id_funcionario, $id_tipo, $valor, $inicio, $fim );";
    $pdo->query($sql);
    echo('{"sql": "'.$sql.'"}');
}