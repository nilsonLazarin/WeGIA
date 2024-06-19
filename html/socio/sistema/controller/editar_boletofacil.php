<?php
    require("../../conexao.php");
    if(!isset($_POST) or empty($_POST)){ 
        $data = file_get_contents( "php://input" );
        $data = json_decode( $data, true ); 
        $_POST = $data;
    }else if(is_string($_POST)){
        $_POST = json_decode($_POST, true);
    }
    try {
        // var_dump($_POST);
        $res = false;
        $api = (isset($_POST['url']) && $_POST['url'] != null) ? $_POST['url'] : ""; 
        $token = (isset($_POST['token']) && $_POST['token'] != null) ? htmlspecialchars($_POST['token'], ENT_QUOTES, 'UTF-8') : ""; 
        $val_min_boleto_uni = (isset($_POST['val_min_boleto_uni']) && $_POST['val_min_boleto_uni'] != null) ? floatval($_POST['val_min_boleto_uni']) : ""; 
        $max_dias_pos_venc = (isset($_POST['max_dias_pos_venc']) && $_POST['max_dias_pos_venc'] != null) ? intval($_POST['max_dias_pos_venc']) : ""; 
        $val_min_parcela= (isset($_POST['val_min_parcela']) && $_POST['val_min_parcela'] != null) ? floatval($_POST['val_min_parcela']) : "";
        $val_max_parcela = (isset($_POST['val_max_parcela']) && $_POST['val_max_parcela'] != null) ? floatval($_POST['val_max_parcela']) : ""; 
        $juros = (isset($_POST['juros']) && $_POST['juros'] != null) ? floatval($_POST['juros']) : ""; 
        $multa = (isset($_POST['multa']) && $_POST['multa'] != null) ? floatval($_POST['multa']) : ""; 
        $agradecimento = (isset($_POST['agradecimento']) && $_POST['agradecimento'] != null) ? htmlspecialchars($_POST['agradecimento'], ENT_QUOTES, 'UTF-8') : "";
        if(mysqli_query($conexao, "UPDATE `infoboletofacil` SET `api`='$api',`token_api`='$token',`val_min_boleto_uni`=$val_min_boleto_uni,`max_dias_pos_venc`= $max_dias_pos_venc ,`juros(%)`=$juros,`multa(%)`=$multa,`val_max_parcela`=$val_max_parcela,`val_min_parcela`=$val_min_parcela,`agradecimento`='$agradecimento' WHERE 1")){ 
            $res = true;
        }
    } catch (Exception $e) {
        
        error_log($e->getMessage());
        $res = false;
    }

    echo json_encode($res);
?>