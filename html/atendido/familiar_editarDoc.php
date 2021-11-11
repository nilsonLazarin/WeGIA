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
    require_once '../../dao/Conexao.php';
    $pdo = Conexao::connect();


    $id = $_GET['id_pessoa'];
    $rg = $_POST['rg'];
    $orgao_emissor = $_POST['orgao_emissor'];
    $cpf = $_POST['cpf'];
    $data_expedicao = $_POST['data_expedicao'];

    if(count($data_expedicao) <10){
        $data_expedicao= null;
    }

    define("ALTERAR_DOC", "UPDATE pessoa SET orgao_emissor=:orgao_emissor, data_expedicao=:data_expedicao, registro_geral=:registro_geral, cpf=:cpf where id_pessoa = :id"); 


    try {
        $pessoa = $pdo->prepare(ALTERAR_DOC);
        $pessoa->bindValue(":id", $id);
        $pessoa->bindValue(":orgao_emissor", $orgao_emissor);
        $pessoa->bindValue(":data_expedicao", $data_expedicao);
        $pessoa->bindValue(":cpf", $cpf);
        $pessoa->bindValue(":registro_geral", $rg);
        $pessoa->execute();
    } catch (PDOException $th) {
        echo "Houve um erro ao inserir a pessoa no banco de dados: $th";
        die();
    }


    $idatendido_familiares = $_GET['idatendido_familiares'];
    header("Location: profile_familiar.php?id_dependente=$idatendido_familiares");

?>