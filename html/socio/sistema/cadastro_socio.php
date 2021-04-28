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
    if(!isset($data_nasc) or ($data_nasc == null) or ($data_nasc == "") or empty($data_nasc) or ($data_nasc == "imp")){
        $data_nasc = "null";
    }else $data_nasc = "'$data_nasc'";

    if(!isset($data_referencia) or ($data_referencia == null) or ($data_referencia == "") or empty($data_referencia) or ($data_referencia == "imp")){
        $data_referencia = "null";
    }else $data_referencia = "'$data_referencia'";

    if(!isset($valor_periodo) or ($valor_periodo == null) or ($valor_periodo == "") or empty($valor_periodo) or ($valor_periodo == "imp")){
        $valor_periodo = "null";
    }else $valor_periodo = "$valor_periodo";

    if(!isset($contribuinte)){
        $contribuinte = null;
    }

    if(!isset($tag) or ($tag == null) or ($tag == "none")){
        $tag = "null";
    }
    // Lidando com aspas simples e duplas
    $socio_nome = addslashes($socio_nome);
    $cidade = addslashes($cidade);
    $bairro = addslashes($bairro);
    $numero = addslashes($numero);
    $rua = addslashes($rua);
    $complemento = addslashes($complemento);

    // si = sem informação
    if($resultado = mysqli_query($conexao, "INSERT INTO `pessoa`(`cpf`, `nome`, `telefone`, `data_nascimento`, `cep`, `estado`, `cidade`, `bairro`, `logradouro`, `numero_endereco`, `complemento`) VALUES ('$cpf_cnpj', '$socio_nome',  '$telefone', $data_nasc, '$cep', '$estado', '$cidade', '$bairro', '$rua', '$numero', '$complemento' )")){
        $id_pessoa = mysqli_insert_id($conexao);
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
    $resultado = mysqli_query($conexao, "INSERT INTO `socio`(`id_pessoa`, `id_sociostatus`, `id_sociotipo`, `email`, `valor_periodo`, `data_referencia`, `id_sociotag`) VALUES ($id_pessoa, $status, $id_sociotipo, '$email', $valor_periodo, $data_referencia, $tag)");
    if(mysqli_affected_rows($conexao)) $cadastrado = true;
}

    echo(json_encode($cadastrado));
?>