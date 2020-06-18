<?php

include("conexao.php");

    $select_img = "SELECT imagem, tipo FROM imagem AS img JOIN tabela_imagem_campo AS tbi ON (tbi.id_imagem = img.id_imagem) WHERE tbi.id_campo = 1";
    $query_img = mysqli_query($conexao, $select_img);
    $fetch_img = mysqli_fetch_row($query_img);

    $imagem = $fetch_img[0];
    $tipo = $fetch_img[1];
    
    $select_pag = "SELECT paragrafo FROM selecao_paragrafo AS sp JOIN campo_imagem AS c_img ON (sp.nome_campo = sp.nome_campo) WHERE c_img.id_campo = 1";
    $query_pag = mysqli_query($conexao, $select_pag);
    $fetch_pag = mysqli_fetch_row($query_pag);

    $paragrafo = $fetch_pag[0];
    echo $logo= '<img src="data:image/jpg;base64,'.base64_encode($imagem.$tipo ).'"/>'."paragrafo:";
    echo $paragrafo;

    


?>