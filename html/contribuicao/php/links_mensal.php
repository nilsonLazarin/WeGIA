<?php
    include("conexao.php");

    $sqltrinta = "SELECT link from doacao_cartao_mensal where valor=30.00";
    $querytrinta = mysqli_query($conexao, $sqltrinta);
    $fetchtrinta = mysqli_fetch_row($querytrinta);
    $trinta = $fetchtrinta[0];

    echo $trinta.",";

    $sqlquar = "SELECT link from doacao_cartao_mensal where valor=40.00";
    $queryquar = mysqli_query($conexao, $sqlquar);
    $fetchquar = mysqli_fetch_row($queryquar);
    $quarenta = $fetchquar[0];

    echo $quarenta.",";

    $sqlcinque = "SELECT link from doacao_cartao_mensal where valor=50.00";
    $querycinque = mysqli_query($conexao, $sqlcinque);
    $fetchtcinque = mysqli_fetch_row($querycinque);
    $cinquenta = $fetchtcinque[0];

    echo $cinquenta.",";

    $sqlcem = "SELECT link from doacao_cartao_mensal where valor=100.00";
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