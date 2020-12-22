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
    if (isset($total_total)){
        $qtd = intval($total_total);
    }

    function saida(){
        extract($_REQUEST);
        if ($total_total < 1){
            deleteEstoque();
            return false;
        }
        $pdo = Conexao::connect();
        $estoque = $pdo->query("SELECT * FROM estoque WHERE id_produto=$id_produto AND id_almoxarifado=$almoxarifado;");
        $estoque = $estoque->fetch(PDO::FETCH_ASSOC);
        if (!$estoque){
            header("Location: ./remover_produto.php?id_produto=$id_produto&flag=danger&msg=Não há nenhum produto do tipo no almoxarifado selecionado");
        }
        $saida = getSaida();
        if (!$saida){
            $saida = addSaida();
        }
        addISaida($saida);
        deleteEstoque();
    }

    function getSaida(){
        extract($_REQUEST);
        $id_pessoa = $_SESSION['id_pessoa'];
        $pdo = Conexao::connect();
        $saida = $pdo->query("SELECT * FROM saida WHERE id_destino=$destino AND id_almoxarifado=$almoxarifado AND id_tipo=$tipo_saida AND id_responsavel=$id_pessoa;");
        $saida = $saida->fetch(PDO::FETCH_ASSOC);
        return $saida;
    }

    function addSaida(){
        extract($_REQUEST);
        $id_pessoa = $_SESSION['id_pessoa'];
        $pdo = Conexao::connect();
        $saida = $pdo->prepare("INSERT INTO saida (id_saida, id_destino, id_almoxarifado, id_tipo, id_responsavel, `data`, hora) VALUES (default, :d, :a, :t, :i, CURDATE(), CURRENT_TIME());") or header("Location: ./remover_produto.php?id_produto=$id_produto&flag=error&msg=Houve um erro ao registrar a saída do item");
        $saida->bindValue(':d', $destino);
        $saida->bindValue(':a', $almoxarifado);
        $saida->bindValue(':t', $tipo_saida);
        $saida->bindValue(':i', $id_pessoa);
        $saida = $saida->execute();
        return $saida;
    }

    function addISaida($saida){
        extract($_REQUEST);
        $id_pessoa = $_SESSION['id_pessoa'];
        $id_saida = $saida['id_saida'];
        $pdo = Conexao::connect();
        $pdo->exec("INSERT INTO isaida (id_isaida, id_saida, id_produto, qtd) VALUES ( default , $id_saida , $id_produto , $total_total );") or header("Location: ./remover_produto.php?id_produto=$id_produto&flag=error&msg=Houve um erro ao registrar a saída do item");
    }

    function deleteEstoque(){
        extract($_REQUEST);
        $pdo = Conexao::connect();
        $pdo->exec("DELETE FROM estoque WHERE id_produto=$id_produto;") or header("Location: ./remover_produto.php?id_produto=$id_produto&flag=error&msg=Houve um erro ao apagar registros de estoque do produto");
    }

    function ocultarProduto(){
        extract($_REQUEST);
        $pdo = Conexao::connect();
        $pdo->exec("UPDATE produto SET oculto=true WHERE id_produto=$id_produto;") or header("Location: ./remover_produto.php?id_produto=$id_produto&flag=error&msg=Houve um erro ao tentar ocultar registros de estoque do produto");
        $pdo->exec("UPDATE ientrada SET oculto=true WHERE id_produto=$id_produto;") or header("Location: ./remover_produto.php?id_produto=$id_produto&flag=error&msg=Houve um erro ao tentar ocultar registros de entrada do produto");
        $pdo->exec("UPDATE isaida SET oculto=true WHERE id_produto=$id_produto;") or header("Location: ./remover_produto.php?id_produto=$id_produto&flag=error&msg=Houve um erro ao tentar ocultar registros de saida do produto");
    }

    if ($qtd){
        // Tem no estoque
        saida();
    }

    ocultarProduto();
    
    header("Location: ./listar_produto.php");
    
?>