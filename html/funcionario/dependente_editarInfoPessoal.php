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


    $id = trim(filter_input(INPUT_GET, 'id_pessoa', FILTER_SANITIZE_NUMBER_INT));
    $nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
    $sobrenome = trim(filter_input(INPUT_POST, 'sobrenomeForm', FILTER_SANITIZE_STRING));
    $sexo = trim(filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING));
    $telefone = trim(filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING));
    $data_nascimento = trim(filter_input(INPUT_POST, 'nascimento', FILTER_SANITIZE_STRING));
    $nome_mae = trim(filter_input(INPUT_POST, 'nome_mae', FILTER_SANITIZE_STRING));
    $nome_pai = trim(filter_input(INPUT_POST, 'nome_pai', FILTER_SANITIZE_STRING));

    define("ALTERAR_INFO_PESSOAL", "UPDATE pessoa SET nome=:nome, sobrenome=:sobrenome, sexo=:sexo, data_nascimento=:data_nascimento, telefone=:telefone, nome_mae=:nome_mae, nome_pai=:nome_pai where id_pessoa = :id"); 


    try {
        $pessoa = $pdo->prepare(ALTERAR_INFO_PESSOAL);
        $pessoa->bindValue(":id", $id);
        $pessoa->bindValue(":nome", $nome);
        $pessoa->bindValue(":sobrenome", $sobrenome);
        $pessoa->bindValue(":sexo", $sexo);
        $pessoa->bindValue(":telefone", $telefone);
        $pessoa->bindValue(":data_nascimento", $data_nascimento);
        $pessoa->bindValue(":nome_mae", $nome_mae);
        $pessoa->bindValue(":nome_pai", $nome_pai);
        $pessoa->execute();
    } catch (PDOException $th) {
        echo "Houve um erro ao inserir a pessoa no banco de dados: $th";
        die();
    }


    $idatendido_familiares = $_GET['idatendido_familiares'];

    header("Location: profile_dependente.php?id_dependente=$idatendido_familiares");

?>