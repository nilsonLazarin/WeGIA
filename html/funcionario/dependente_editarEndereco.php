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
    $cep = $_POST['cep'];
    $estado = $_POST['uf'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero_residencia'];
    $complemento = $_POST['complemento'];
    $ibge = $_POST['ibge'];

    if (!preg_match('/^\d{5}-\d{3}$/', $cep)) {
        die("CEP inválido");
    }

    if (!is_numeric($numero)) {
        //die("Número de residência inválido");
        $numero = '';
    }

    if (empty($estado) || empty($cidade) || empty($bairro) || empty($rua)) {
        die("Preencha todos os campos obrigatórios.");
    }

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


    $idatendido_familiares = $_GET['idatendido_familiares'];
    header("Location: profile_dependente.php?id_dependente=$idatendido_familiares");

?>