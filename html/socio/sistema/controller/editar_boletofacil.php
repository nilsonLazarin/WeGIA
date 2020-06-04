<?php
    require("../../conexao.php");
    if(!isset($_POST) or empty($_POST)){
        $data = file_get_contents( "php://input" );
        $data = json_decode( $data, true );
        $_POST = $data;
    }else if(is_string($_POST)){
        $_POST = json_decode($_POST, true);
    }
    // var_dump($_POST);
    $res = false;
    $api = $_POST['url'];
    $token = $_POST['token'];
    $val_min_boleto_uni = $_POST['val_min_boleto_uni'];
    $max_dias_pos_venc = $_POST['max_dias_pos_venc'];
    $val_min_parcela= $_POST['val_min_parcela'];
    $val_max_parcela = $_POST['val_max_parcela'];
    $juros = $_POST['juros'];
    $multa = $_POST['multa'];
    $agradecimento = $_POST['agradecimento'];
    if(mysqli_query($conexao, "UPDATE `infoboletofacil` SET `api`='$api',`token_api`='$token',`val_min_boleto_uni`=$val_min_boleto_uni,`max_dias_pos_venc`= $max_dias_pos_venc ,`juros(%)`=$juros,`multa(%)`=$multa,`val_max_parcela`=$val_max_parcela,`val_min_parcela`=$val_min_parcela,`agradecimento`='$agradecimento' WHERE 1")){
        $res = true;
    }
    echo json_encode($res);
?>