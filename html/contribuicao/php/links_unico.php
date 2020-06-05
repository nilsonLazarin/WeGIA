<?php

include("conexao.php");

    $sql = "SELECT * FROM doacao_cartao_avulso where id = 0";
    $query = mysqli_query($conexao, $sql);
    $fetch = mysqli_fetch_row($query);
    $paypal = $fetch[1];

    $sqlpg = "SELECT * FROM doacao_cartao_avulso where id = 1";
    $querypg = mysqli_query($conexao, $sqlpg);
    $fetchr = mysqli_fetch_row($querypg);
    $pagseguro = $fetchr[1];

    echo$paypal;
    echo$pagseguro;


?>
