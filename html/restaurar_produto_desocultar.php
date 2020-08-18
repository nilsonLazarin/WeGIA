<?php

    require_once  "../dao/Conexao.php";

    session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
    }
    
    if (!isset($_SESSION['id_pessoa'])){
        echo("Não foi possível obter o id do usuário logado!<br/><a onclick='window.history.back()'>Voltar</a>");
        die();
    }

    extract($_REQUEST);
    $id_produto = intval($id_produto);
    if ($id_produto < 1){
        header("Location: ./restaurar_produto.php?id_produto=$id_produto&flag=error&msg=Id inválido: Deve ser maior do que 0");
    }

    extract($_REQUEST);
    $pdo = Conexao::connect();
    $produto = $pdo->query("SELECT * FROM produto WHERE id_produto=$id_produto;")->fetch(PDO::FETCH_ASSOC);
    if (!!$produto){
        $pdo->exec("UPDATE produto SET oculto=false WHERE id_produto=$id_produto;");
        $pdo->exec("UPDATE isaida SET oculto=false WHERE id_produto=$id_produto;");
        $pdo->exec("UPDATE ientrada SET oculto=false WHERE id_produto=$id_produto;");
    }else{
        header("Location: ./restaurar_produto.php?id_produto=$id_produto&flag=error&msg=Não foi possível localizar o produto com id = '$id_produto'!");
    }

    header("Location: ./cadastro_produto.php");
?>