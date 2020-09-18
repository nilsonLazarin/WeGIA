<?php

    include("conexao.php");

    $data = date("Y-m-d");
    $ip_log = $_SERVER['REMOTE_ADDR'];
    $horahoje = $_POST['hora'];
    $sistema = $_POST['sistema'];
    $status = 0;
    $email = $_POST['email'];
    $doc = $_POST['doc'];
    $valor_doacao = $_POST['valor_doacao'];
    $data_vencimento = $_POST['dataV'];

    $query = mysqli_query($conexao,"INSERT INTO log_contribuicao(id_socio, ip, data, hora, id_sistema, valor_boleto, data_venc_boleto)values((SELECT id_socio FROM socio, pessoa WHERE pessoa.id_pessoa=socio.id_pessoa AND pessoa.cpf='$doc'), '$ip_log', '$data', '$horahoje', '$sistema', '$valor_doacao', '$data_vencimento')");



?>