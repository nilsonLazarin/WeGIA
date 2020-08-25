<?php
    require("../conexao.php");
    if(!isset($_POST) or empty($_POST)){
        $data = file_get_contents( "php://input" );
        $data = json_decode( $data, true );
        $_POST = $data;
    }else if(is_string($_POST)){
        $_POST = json_decode($_POST, true);
    }
    $cadastrado =  false;

    extract($_REQUEST);
    if(!isset($data_nasc)){
        $data_nasc = null;
    }

    if($resultado = mysqli_query($conexao, "INSERT INTO `pessoa`(`cpf`, `nome`, `telefone`, `data_nascimento`, `cep`, `estado`, `cidade`, `bairro`, `logradouro`, `numero_endereco`, `complemento`) VALUES ('$cpf_cnpj', '$socio_nome',  '$telefone', '$data_nasc', '$cep', '$estado', '$cidade', '$bairro', '$rua', '$numero', '$complemento' )")){
        $id_pessoa = mysqli_insert_id($conexao);
        switch($pessoa){
            case "juridica": if($contribuinte == "mensal") $id_sociotipo = 3; else $id_sociotipo = 1; break;
            case "fisica": if($contribuinte == "mensal") $id_sociotipo = 2; else $id_sociotipo = 0; break;
        }

        $resultado = mysqli_query($conexao, "INSERT INTO `socio`(`id_pessoa`, `id_sociostatus`, `id_sociotipo`, `email`) VALUES ($id_pessoa, $status, $id_sociotipo, '$email')");
        if(mysqli_affected_rows($conexao)) $cadastrado = true;

    }

    echo json_encode($cadastrado);
?>