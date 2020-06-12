<?php
    require_once('../dao/Conexao.php');
    require_once('../classes/Produto.php');
    require_once('../config.php');
    $almox = $_REQUEST['almox'];
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $produtos = array();
    if($conexao){
        $query = mysqli_query($conexao, "SELECT produto.id_produto, produto.codigo, produto.descricao, estoque.qtd, produto.preco FROM produto, estoque WHERE produto.id_produto=estoque.id_produto AND estoque.qtd>0 AND estoque.id_almoxarifado=$almox");
        while($resultado = mysqli_fetch_array($query)){
            $produtos[] = $resultado; 
        }
        echo(json_encode($produtos));
    }else echo false;
?>