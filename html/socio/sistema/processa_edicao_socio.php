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
    $id = $_POST['id_socio'];
    $nome = $_POST['socio_nome'];
    $pessoa = $_POST['pessoa'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $cep = $_POST['cep'];
    if(isset($_POST['data_nasc'])){
        $data_nasc = $_POST['data_nasc'];
    }
    if($resultado = mysqli_query($conexao, "UPDATE socio SET `nome` = '$nome', `email`='$email', `telefone`='$telefone', `tipo`='$pessoa' WHERE id=$id")){
        $resultado = mysqli_query($conexao, "UPDATE `endereco` SET `logradouro`='$rua', `numero`='$numero', `complemento`='$complemento', `cep`='$cep', `bairro`='$bairro', `cidade`='$cidade', `estado`='$estado'  WHERE idsocio=$id");
        if($pessoa == "juridica"){
            if($resultado = mysqli_query($conexao, "UPDATE `pessoajuridica` SET `cnpj` = '$cpf_cnpj' WHERE idsocio=$id")){
                $cadastrado = true;
            }
        }else{
            if($resultado = mysqli_query($conexao, "UPDATE `pessoafisica` SET `cpf` = '$cpf_cnpj' WHERE idsocio=$id")){
                $cadastrado = true;
            }
        }
    }

    echo json_encode($cadastrado);
?>