<?php
    require_once  "../dao/Conexao.php";

    session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
    }
    
    if (!isset($_SESSION['id_pessoa'])){
        echo("Não há id_pessoa<br/><a onclick='window.history.back()'>Voltar</a>");
        die();
    }
    extract($_REQUEST);
    if (sizeof($_REQUEST) != 6){
        $action = '';
        $id_produto = isset($id_produto) ? $id_produto : null;
    }

    function saida(){
        extract($_REQUEST);
        if ($total_total < 1){
            header("Location: ./remover_produto.php?id_produto=$id_produto&flag=warn&msg=O produto já não está mais em estoque");
        }
        $pdo = Conexao::connect();
        $estoque = $pdo->query("SELECT * FROM estoque WHERE id_produto=$id_produto AND id_almoxarifado=$almoxarifado;");
        $estoque = $estoque->fetch(PDO::FETCH_ASSOC);
        if (!$estoque){
            header("Location: ./remover_produto.php?id_produto=$id_produto&flag=danger&msg=Não há nenhum produto do tipo no almoxarifado selecionado");
        }
        $saida = getSaida();
        if (!$saida){
            $saida = setSaida();
        }
        setISaida($saida);
        deleteEstoque();
        header("Location: ./listar_produto.php");
    }

    function substituicao(){
        echo("substituicao");
    }

    function getSaida(){
        extract($_REQUEST);
        $id_pessoa = $_SESSION['id_pessoa'];
        $pdo = Conexao::connect();
        $saida = $pdo->query("SELECT * FROM saida WHERE id_destino=$destino AND id_almoxarifado=$almoxarifado AND id_tipo=$tipo_saida AND id_responsavel=$id_pessoa;");
        $saida = $saida->fetch(PDO::FETCH_ASSOC);
        return $saida;
    }

    function setSaida(){
        extract($_REQUEST);
        $id_pessoa = $_SESSION['id_pessoa'];
        $pdo = Conexao::connect();
        $saida = $pdo->prepare("INSERT INTO saida VALUES (default, :d, :a, :t, :i, CURDATE(), CURRENT_TIME(), NULL);") or die(header("Location: ./remover_produto.php?id_produto=$id_produto&flag=error&msg=Houve um erro ao registrar a saída do item"));
        $saida->bindValue(':d', $destino);
        $saida->bindValue(':a', $almoxarifado);
        $saida->bindValue(':t', $tipo_saida);
        $saida->bindValue(':i', $id_pessoa);
        $saida = $saida->execute();
        return $saida;
    }

    function setISaida($saida){
        extract($_REQUEST);
        $id_pessoa = $_SESSION['id_pessoa'];
        $id_saida = $saida['id_saida'];
        $pdo = Conexao::connect();
        $pdo->exec("INSERT INTO isaida VALUES (default, $id_saida , $id_produto , $total_total , NULL);") or die(header("Location: ./remover_produto.php?id_produto=$id_produto&flag=error&msg=Houve um erro ao registrar a saída do item"));
    }

    function deleteEstoque(){
        extract($_REQUEST);
        $pdo = Conexao::connect();
        $pdo->exec("DELETE FROM estoque WHERE id_produto=$id_produto;") or die(header("Location: ./remover_produto.php?id_produto=$id_produto&flag=error&msg=Houve um erro ao apagar registros de estoque do produto"));
    }

    switch ($action){
        case 'saida':
            saida();
        break;
        case 'substituicao':
            substituicao();
        break;
        default:
            if (isset($id_produto)){
                header("Location: ./remover_produto.php?id_produto=$id_produto&msg=Ação não especificada&flag=error");
            }else{
                header("Location: ./listar_produto.php");
            }
    }
?>