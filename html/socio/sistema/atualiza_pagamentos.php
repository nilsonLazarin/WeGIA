<?php
    require("../conexao.php");
    if(!isset($_POST) or empty($_POST)){
        $data = file_get_contents( "php://input" );
        $data = json_decode( $data, true );
        $_POST = $data;
    }else if(is_string($_POST)){
        $_POST = json_decode($_POST, true);
    }

    extract($_REQUEST);
    $cadastrado = false;
    
    mysqli_query($conexao, "UPDATE cobrancas set status='Pago', data_pagamento='$data', valor_pago=$valor where codigo = $codigo");

    if(mysqli_affected_rows($conexao)) $cadastrado = true;

    echo(json_encode($cadastrado));
?>