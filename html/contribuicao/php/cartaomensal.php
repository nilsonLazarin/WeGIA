<?php
    include("conexao.php");

    $sqltrinta = "SELECT link from doacao_cartao_mensal where id = 0";
    $querytrinta = mysqli_query($conexao, $sqltrinta);
    $fetchtrinta = mysqli_fetch_row($querytrinta);
    $trinta = $fetchtrinta[0];

    echo $trinta.",";

    $sqlquar = "SELECT link from doacao_cartao_mensal where id = 1";
    $queryquar = mysqli_query($conexao, $sqlquar);
    $fetchquar = mysqli_fetch_row($queryquar);
    $quarenta = $fetchquar[0];

    echo $quarenta.",";

    $sqlcinque = "SELECT link from doacao_cartao_mensal where id = 2";
    $querycinque = mysqli_query($conexao, $sqlcinque);
    $fetchtcinque = mysqli_fetch_row($querycinque);
    $cinquenta = $fetchtcinque[0];

    echo $cinquenta.",";

    $sqlcem = "SELECT link from doacao_cartao_mensal where id = 3";
    $querycem = mysqli_query($conexao, $sqlcem);
    $fetchtcem = mysqli_fetch_row($querycem);
    $cem = $fetchtcem[0];

    echo$cem.",";

    $array['trinta']=$trinta;
    $array['quarenta']=$quarenta;
    $array['cinquenta']=$cinquenta;
    $array['cem']=$cem;

    echo$array;
    

?>