<?php
    require("../conexao.php");
    if(!isset($_POST) or empty($_POST)){
        $data = file_get_contents( "php://input" );
        $data = json_decode( $data, true );
        $_POST = $data;
    }else if(is_string($_POST)){
        $_POST = json_decode($_POST, true);
    }
    var_dump($_REQUEST);
    $deletado =  false;
    $id = $_POST['id_socio'];
    $pessoa = $_POST['pessoa'];
    if($socio = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM `socio` WHERE id_socio = $id"))){
        echo("teste1");
        $id_pessoa = $socio['id_pessoa'];
        if(mysqli_query($conexao, "DELETE FROM `socio` WHERE id_socio=$id")){
            echo("teste2");
            if(mysqli_query($conexao, "DELETE FROM `pessoa` WHERE id_pessoa=$id_pessoa")){
                echo("teste3");
                $deletado = true;
            }
        }
    }


    echo json_encode($deletado);
?>