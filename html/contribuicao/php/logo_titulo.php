<?php

include("conexao.php");

    
    $selectImg = "SELECT imagem, tipo FROM imagem WHERE nome = 'logolaje'";
    $query = mysqli_query($conexao, $selectImg);
    $arquivo = mysqli_fetch_row($query);

    $imagem = $arquivo[0];
    $tipo = $arquivo[1];
   
    $selectPa = "SELECT paragrafo FROM selecao_paragrafo WHERE nome_campo = 'Logo'";
    $queryP = mysqli_query($conexao, $selectPa);
    $paragrafo = mysqli_fetch_row($queryP);

    $texto = $paragrafo[0];

    echo $logo= '<img src="data:image/jpg;base64,'.base64_encode($imagem.$tipo ).'"/>'."paragrafo:";
    echo $texto;
    


?>