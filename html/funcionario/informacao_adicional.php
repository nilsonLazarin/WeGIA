<?php
extract($_REQUEST);

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);


require_once "../../dao/Conexao.php";
$pdo = Conexao::connect();

if ($action == "adicionar_descricao"){
    $descricao = trim(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING));

    if(!$descricao || strlen($descricao) == 0){
        http_response_code(400);
        echo json_encode(['erro' => 'A descrição não pode ser vazia']);
        exit();
    }

    $sql = "INSERT INTO funcionario_listainfo (descricao) VALUES (:descricao)";
    $response_query = "SELECT * FROM funcionario_listainfo;";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':descricao', $descricao);

        $stmt->execute();

        $informacoes = $pdo->query($response_query)->fetchAll(PDO::FETCH_ASSOC);
        foreach($informacoes as $index => $informacao){
            $informacoes[$index]['descricao'] = htmlspecialchars($informacao['descricao']);
        }

        echo json_encode($informacoes);
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

if ($action == "adicionar"){
    $sql = "INSERT INTO funcionario_outrasinfo VALUES ( default , $id_funcionario , $id_descricao , '".addslashes($dados)."' )";
    try {
        $pdo->query($sql);
        listar($pdo);
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

if ($action == "remover"){
    $sql = "DELETE FROM funcionario_outrasinfo WHERE idfunncionario_outrasinfo = $id_descricao;";
    try {
        $pdo->query($sql);
        listar($pdo);
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

if ($action == "idInfoAdicional"){
    // $sql = "SELECT * FROM  funcionario_outrasinfo;";
    try {
        // $pdo->query($sql);
        $result = $pdo->query("SELECT max(idfunncionario_outrasinfo) FROM  funcionario_outrasinfo;")->fetch(PDO::FETCH_ASSOC);
        // listar();
        echo json_encode($result);
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

if ($action == "selectDescricao"){
    // $sql = "SELECT * FROM  funcionario_outrasinfo;";
    try {
        // $pdo->query($sql);
        // $result = $pdo->query("SELECT * FROM funcionario_listainfo;")->fetch(PDO::FETCH_ASSOC);
        // listar();
        // echo json_encode($result);
        echo json_encode($pdo->query("SELECT * FROM funcionario_listainfo;")->fetchAll(PDO::FETCH_ASSOC));

    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

if ($action == "listar"){
    listar($pdo);
}

function listar(PDO $pdo){
    $response_query = "SELECT * FROM funcionario_outrasinfo o JOIN funcionario_listainfo l ON o.funcionario_listainfo_idfuncionario_listainfo = l.idfuncionario_listainfo;";
    try {
        echo json_encode($pdo->query($response_query)->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}

die();