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

    if(!isset($data_nasc) or ($data_nasc == null) or ($data_nasc == "") or empty($data_nasc) or ($data_nasc == "imp")){
        $data_nasc = "null";
    }else $data_nasc = "'$data_nasc'";


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

    if(!isset($tag) or ($tag == null) or ($tag == "none")){
        $tag = "null";
    }


    $id_pessoa = mysqli_fetch_array(mysqli_query($conexao, "SELECT id_pessoa FROM socio WHERE id_socio = $id_socio"))['id_pessoa'];
    if($resultado = mysqli_query($conexao, "UPDATE `pessoa` SET `cpf` = '$cpf_cnpj', `nome` = '$socio_nome', `telefone` = '$telefone', `data_nascimento` = $data_nasc, `cep` = '$cep', `estado` = '$estado', `cidade` = '$cidade', `bairro` = '$bairro', `logradouro` = '$rua', `numero_endereco` = '$numero', `complemento` = '$complemento' WHERE id_pessoa = $id_pessoa")){
        switch($pessoa){
            case "juridica": 
            if($contribuinte == "mensal"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 23;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 43;
                }else{
                    $id_sociotipo = 3;
                }
            }else if($contribuinte == "casual"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 21;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 41;
                }else{
                    $id_sociotipo = 1;
                }
            }else if($contribuinte == "bimestral"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 25;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 45;
                }else{
                    $id_sociotipo = 7;
                }
            }else if($contribuinte == "trimestral"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 27;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 47;
                }else{
                    $id_sociotipo = 9;
                }
            }else if($contribuinte == "semestral"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 29;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 49;
                }else{
                    $id_sociotipo = 11;
                }
            }
            
            if($contribuinte == null || $contribuinte == "si" || $contribuinte == ""){
                $id_sociotipo = 5;
            }  break;

            case "fisica": 
            if($contribuinte == "mensal"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 22;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 42;
                }else{
                    $id_sociotipo = 2;
                }
            }else if($contribuinte == "casual"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 20;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 40;
                }else{
                    $id_sociotipo = 0;
                }
            }else if($contribuinte == "bimestral"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 24;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 44;
                }else{
                    $id_sociotipo = 6;
                }
            }else if($contribuinte == "trimestral"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 26;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 46;
                }else{
                    $id_sociotipo = 8;
                }
            }else if($contribuinte == "semestral"){
                if($tipo_contribuicao == 2){
                    $id_sociotipo = 28;
                }else if($tipo_contribuicao == 3){
                    $id_sociotipo = 48;
                }else{
                    $id_sociotipo = 10;
                }
            }
            
            
            if($contribuinte == null || $contribuinte == "si" || $contribuinte == ""){
                $id_sociotipo = 4;
            }  break;
    }
        if($resultado = mysqli_query($conexao, "UPDATE `socio` SET `id_sociostatus`= '$status', `id_sociotipo` = $id_sociotipo, `email` = '$email', `data_referencia` = $data_referencia, `valor_periodo` = $valor_periodo, `id_sociotag` = $tag WHERE id_socio = $id_socio")){
            $cadastrado = true;
        }
        

    }

    echo json_encode($cadastrado);
?>