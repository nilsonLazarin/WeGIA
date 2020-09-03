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

    if(!isset($contribuinte)){
        $contribuinte = null;
    }

    $id_pessoa = mysqli_fetch_array(mysqli_query($conexao, "SELECT id_pessoa FROM socio WHERE id_socio = $id_socio"))['id_pessoa'];
    if($resultado = mysqli_query($conexao, "UPDATE `pessoa` SET `cpf` = '$cpf_cnpj', `nome` = '$socio_nome', `telefone` = '$telefone', `data_nascimento` = '$data_nasc', `cep` = '$cep', `estado` = '$estado', `cidade` = '$cidade', `bairro` = '$bairro', `logradouro` = '$rua', `numero_endereco` = '$numero', `complemento` = '$complemento' WHERE id_pessoa = $id_pessoa")){
        switch($pessoa){
            case "juridica": if($contribuinte == "mensal"){
                $id_sociotipo = 3;
            }else{
                $id_sociotipo = 1;
            }if($contribuinte == null){
                $id_sociotipo = 5;
            }  break;
            case "fisica": if($contribuinte == "mensal"){
                $id_sociotipo = 2;
            } else{
                $id_sociotipo = 0;
            }if($contribuinte == null || $contribuinte == "si"){
                $id_sociotipo = 4;
            }  break;
        }
        if($resultado = mysqli_query($conexao, "UPDATE `socio` SET `id_sociostatus`= $status, `id_sociotipo` = $id_sociotipo, `email` = '$email' WHERE id_socio = $id_socio")){
            $cadastrado = true;
        }
        

    }

    echo json_encode($cadastrado);
?>