<?php

    require_once('conexao.php');
    $query = new Conexao;


    $data = date("Y-m-d");
    $ip_log = $_SERVER['REMOTE_ADDR'];
    $horahoje = $_POST['hora'];
    $sistema = $_POST['sistema'];
    $tipoSocio = $_POST['socioTipo'];
    $email = $_POST['email'];
    $doc = $_POST['doc'];
    $valor_doacao = $_POST['valor_doacao'];
    $data_vencimento = $_POST['dataV'];

    //$query->query("INSERT INTO log_contribuicao(id_socio, ip, data, hora, id_sistema, valor_boleto, data_venc_boleto, id_sociotipo)values((SELECT id_socio FROM socio, pessoa WHERE pessoa.id_pessoa=socio.id_pessoa AND pessoa.cpf='$doc'), '$ip_log', '$data', '$horahoje', '$sistema', '$valor_doacao', '$data_vencimento', (SELECT id_sociotipo FROM socio JOIN pessoa ON (pessoa.id_pessoa = socio.id_pessoa)  WHERE pessoa.cpf = '$doc')");

    $query->querydados("SELECT id_socio FROM socio, pessoa WHERE pessoa.id_pessoa=socio.id_pessoa AND pessoa.cpf='$doc'");
    $result = $query->result();
    $id_socio = $result['id_socio'];

    $query->query("INSERT INTO log_contribuicao(id_socio, ip, data, hora, id_sistema, valor_boleto, data_venc_boleto, id_sociotipo)values('$id_socio', '$ip_log', '$data', '$horahoje', '$sistema', '$valor_doacao', '$data_vencimento', '$tipoSocio')");
?>