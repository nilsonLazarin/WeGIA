
<?php

include("conexao.php");

    
    $selectImg = "SELECT imagem.imagem, imagem.tipo FROM imagem, campo_imagem, tabela_imagem_campo WHERE campo_imagem.id_campo=tabela_imagem_campo.id_campo AND imagem.id_imagem=tabela_imagem_campo.id_imagem AND campo_imagem.nome_campo='Logo'";
    $query = mysqli_query($conexao, $selectImg);
    $arquivo = mysqli_fetch_row($query);
    
    $tipo =$arquivo[1];

    $imagem = $arquivo[0];
    
    $selectPa = "SELECT paragrafo FROM selecao_paragrafo WHERE nome_campo = 'ContribuiçãoMSG'";
    $queryP = mysqli_query($conexao, $selectPa);
    $paragrafo = mysqli_fetch_row($queryP);

    $texto = $paragrafo[0];

    echo $logo= '<img width="100px" src=data:image/'.$tipo.';base64,'.$imagem.'>'."paragrafo:";
    echo $texto;
    
?>
