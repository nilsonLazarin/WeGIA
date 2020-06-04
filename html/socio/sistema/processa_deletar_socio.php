<?php
    require("../conexao.php");
    if(!isset($_POST) or empty($_POST)){
        $data = file_get_contents( "php://input" );
        $data = json_decode( $data, true );
        $_POST = $data;
    }else if(is_string($_POST)){
        $_POST = json_decode($_POST, true);
    }
    $deletado =  false;
    $id = $_POST['id_socio'];
    $pessoa = $_POST['pessoa'];
    if(mysqli_query($conexao, "DELETE FROM `endereco` WHERE idsocio=$id")){
        if($pessoa == "fisica"){
           if(mysqli_query($conexao, "DELETE FROM `pessoafisica` WHERE idsocio=$id")){
                if(mysqli_query($conexao, "DELETE FROM `socio` WHERE id=$id")){
                    $deletado = true;
                }
           }
        }else{
            if(mysqli_query($conexao, "DELETE FROM `pessoajuridica` WHERE idsocio=$id")){
                if(mysqli_query($conexao, "DELETE FROM `socio` WHERE id=$id")){
                    $deletado = true;
                }
           }
        }
    }


    echo json_encode($deletado);
?>