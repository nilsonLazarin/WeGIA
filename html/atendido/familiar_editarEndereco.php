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


    $id = filter_input(INPUT_GET, 'id_pessoa', FILTER_VALIDATE_INT);
    $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
    $estado = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING);
    $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
    $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
    $rua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING);
    $numero = filter_input(INPUT_POST, 'numero_residencia', FILTER_SANITIZE_STRING);
    $complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
    $ibge = filter_input(INPUT_POST, 'ibge', FILTER_SANITIZE_STRING);

    define("ALTERAR_END", "UPDATE pessoa SET cep=:cep, estado=:estado, cidade=:cidade, bairro=:bairro, logradouro=:rua, numero_endereco=:numero, complemento=:complemento, ibge=:ibge where id_pessoa = :id"); 


    try {
        $pessoa = $pdo->prepare(ALTERAR_END);
        $pessoa->bindValue(":id", $id);
        $pessoa->bindValue(":cep", $cep);
        $pessoa->bindValue(":estado", $estado);
        $pessoa->bindValue(":cidade", $cidade);
        $pessoa->bindValue(":bairro", $bairro);
        $pessoa->bindValue(":rua", $rua);
        $pessoa->bindValue(":numero", $numero);
        $pessoa->bindValue(":complemento", $complemento);
        $pessoa->bindValue(":ibge", $ibge);
        $pessoa->execute();
    } catch (PDOException $th) {
        echo "Houve um erro ao inserir a pessoa no banco de dados: $th";
        die();
    }


    $idatendido_familiares = filter_input(INPUT_GET, 'idatendido_familiares', FILTER_VALIDATE_INT);
    if (!$idatendido_familiares) {
        die('ID inválido para redirecionamento.');
    }

    header("Location: profile_familiar.php?id_dependente=$idatendido_familiares");
    exit();

?>