<?php

include("conexao.php");

    $SISTEMA = $_POST["id_teste"];


    $QUERY = mysqli_query($conexao, "SELECT url FROM doacao_cartao_avulso WHERE id_sistema = $SISTEMA");
    $RESPOSTA = mysqli_fetch_row($QUERY);
    $LINK = $RESPOSTA[0];

    $vetor['LINK_AVULSO'] = $LINK;

    $QUERY_M = mysqli_query($conexao, "SELECT valor, url FROM doacao_cartao_menal WHERE id_sistema = $SISTEMA");

    $array = json_encode($vetor);
    echo $array;

?>