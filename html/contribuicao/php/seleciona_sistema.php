<?php

$sistema = $_GET['sistema'];
    if(empty($sistema))
    {
        header("Location: atualiza_sistema_doacao.php?id_sistema=3");
    }else{
        header("Location: atualiza_sistema_doacao.php?id_sistema='$sistema'");
    }
    

?>