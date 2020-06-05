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

    $resultado = mysqli_query($conexao, "INSERT INTO `socio`(`nome`, `email`, `telefone`, `tipo`) VALUES ('$nome', '$email', '$telefone', '$pessoa')");
    if(mysqli_affected_rows($conexao) == 1){
        $id = mysqli_insert_id($conexao);
        $resultado = mysqli_query($conexao, "INSERT INTO `endereco`(`idsocio`, `logradouro`, `numero`, `complemento`, `cep`, `bairro`, `cidade`, `estado`) VALUES ($id,'$rua', '$numero', '$complemento', '$cep', '$bairro', '$cidade', '$estado')");
        if($pessoa == "juridica"){
            $resultado = mysqli_query($conexao, "INSERT INTO `pessoajuridica`(`idsocio`, `cnpj`) VALUES ('$id', '$cpf_cnpj')");
            if(mysqli_affected_rows($conexao)) $cadastrado = true;
        }else{
            $resultado = mysqli_query($conexao, "INSERT INTO `pessoafisica`(`idsocio`, `cpf`, datanascimento) VALUES ('$id', '$cpf_cnpj', '$data_nasc')");
            if(mysqli_affected_rows($conexao)) $cadastrado = true;
        }
    }

    echo json_encode($cadastrado);
?>