<?php

include("conexao.php");

    $nome=$_POST['nome'];
    $tel=$_POST['telefone'];
    $email=$_POST['email'];
    $tipo=$_POST['tipo'];
    $doc = $_POST['doc'];
    $dataN = $_POST['datanascimento'];

    $sqlsocio = "insert into socio(cpf_cnpj, nome, email, telefone, tipo, data_nascimento) values('$doc',$nome','$email', '$tel','$tipo')";
    $querysocio = mysqli_query($conexao, $sqlsocio);
    $linhassocio = mysqli_affected_rows($conexao);

    $idsql = "select last_insert_id()";
    $queryid = mysqli_query($conexao, $idsql);
    $registro = mysqli_fetch_row($queryid);
    $idsocio = $registro[0];

    $data = date("Y-m-d");
    $ip_log = $_SERVER['REMOTE_ADDR'];
    $horahoje = $_POST['hora'];
    $sistema = $_POST['sistema'];

    $sqllog = "insert into log(id_socio, ip, data, hora, id_sistema)values('$idsocio','$ip_log', '$data', '$horahoje', '$sistema')";
    $querylog=mysqli_query($conexao, $sqllog);
    $linhaslog = mysqli_affected_rows($conexao);

    $cep=$_POST['cep'];
    $rua=$_POST['rua'];
    $numero=$_POST['numero'];
    $compl=$_POST['comp'];
    $bairro=$_POST['bairro'];
    $cidade=$_POST['cidade'];
    $uf=$_POST['uf'];

    $sqlAdd = "insert into endereco(idsocio, logradouro, numero, complemento, cep, bairro, cidade, estado) values('$idsocio', '$rua', '$numero', '$compl', '$cep', '$bairro', '$cidade', '$uf')";
    $queryAdd = mysqli_query($conexao, $sqlAdd);
    $linhasAdd = mysqli_affected_rows($conexao);

    $array['linhas_socio'] = $linhassocio;
    $array['linhas_add'] = $linhasAdd;
    $array['linhas_log'] = $linhaslog;

    echo(json_encode($array));

?>
