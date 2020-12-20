<?php
    require_once './permissao/permissao.php';
    permissao($_SESSION['id_pessoa'], 91);

    if (!isset($id_funcionario) && !isset($id_almoxarifado)){
        header("Location: ./geral/editar_permissoes.php?msg=Preencha todos os campos antes de prosseguir!&flag=warn");
    }
    extract($_REQUEST);

    session_start();
    if (!isset($_SESSION['id_pessoa'])){
        header("Location: ../index.php");
    }

    require_once '../dao/Conexao.php';
    $pdo = Conexao::connect();

    $almox = $pdo->query("SELECT * FROM almoxarife WHERE id_funcionario=$id_funcionario AND id_almoxarifado=$id_almoxarifado;")->fetch(PDO::FETCH_ASSOC);
    if ($almox) {
        header("Location: ./geral/editar_permissoes.php?msg=Funcionário já cadastrado para o Almoxarifado escolhido!&flag=warn");
    }else{
        try{
            $pdo->exec("INSERT INTO almoxarife (id_funcionario, id_almoxarifado) VALUES ( $id_funcionario , $id_almoxarifado );");
            header("Location: ./geral/editar_permissoes.php?msg=Funcionário cadastrado como almoxarife!&flag=success");
        }catch (PDOExeption $e){
            header("Location: ./geral/editar_permissoes.php?msg=Erro: &flag=erro&log=$e");
        }
    }

?>