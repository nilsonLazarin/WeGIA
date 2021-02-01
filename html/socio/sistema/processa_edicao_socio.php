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

    if(!isset($data_referencia) or ($data_referencia == null) or ($data_referencia == "") or empty($data_referencia) or ($data_referencia == "imp")){
        $data_referencia = "null";
    }else $data_referencia = "'$data_referencia'";

    if(!isset($valor_periodo) or ($valor_periodo == null) or ($valor_periodo == "") or empty($valor_periodo) or ($valor_periodo == "imp")){
        $valor_periodo = "null";
    }else $valor_periodo = "'$valor_periodo'";

    // Lidando com aspas simples e duplas
    $socio_nome = addslashes($socio_nome);
    $cidade = addslashes($cidade);
    $bairro = addslashes($bairro);
    $numero = addslashes($numero);
    $rua = addslashes($rua);
    $complemento = addslashes($complemento);


    $id_pessoa = mysqli_fetch_array(mysqli_query($conexao, "SELECT id_pessoa FROM socio WHERE id_socio = $id_socio"))['id_pessoa'];
    if($resultado = mysqli_query($conexao, "UPDATE `pessoa` SET `cpf` = '$cpf_cnpj', `nome` = '$socio_nome', `telefone` = '$telefone', `data_nascimento` = '$data_nasc', `cep` = '$cep', `estado` = '$estado', `cidade` = '$cidade', `bairro` = '$bairro', `logradouro` = '$rua', `numero_endereco` = '$numero', `complemento` = '$complemento' WHERE id_pessoa = $id_pessoa")){
        switch($pessoa){
            case "juridica": 
            if($contribuinte == "mensal"){
                $id_sociotipo = 3;
            }else if($contribuinte == "casual"){
                $id_sociotipo = 1;
            }else if($contribuinte == "bimestral"){
                $id_sociotipo = 7;
            }else if($contribuinte == "trimestral"){
                $id_sociotipo = 9;
            }else if($contribuinte == "semestral"){
                $id_sociotipo = 11;
            }
            
            if($contribuinte == null || $contribuinte == "si" || $contribuinte == ""){
                $id_sociotipo = 5;
            }  break;

            case "fisica": 
            if($contribuinte == "mensal"){
                $id_sociotipo = 2;
            }else if($contribuinte == "casual"){
                $id_sociotipo = 0;
            }else if($contribuinte == "bimestral"){
                $id_sociotipo = 6;
            }else if($contribuinte == "trimestral"){
                $id_sociotipo = 8;
            }else if($contribuinte == "semestral"){
                $id_sociotipo = 10;
            }
            
            
            if($contribuinte == null || $contribuinte == "si" || $contribuinte == ""){
                $id_sociotipo = 4;
            }  break;
        }
        if($resultado = mysqli_query($conexao, "UPDATE `socio` SET `id_sociostatus`= '$status', `id_sociotipo` = '$id_sociotipo', `email` = '$email', `data_referencia` = $data_referencia, `valor_periodo` = $valor_periodo WHERE id_socio = $id_socio")){
            $cadastrado = true;
        }
        

    }

    echo json_encode($cadastrado);
?>