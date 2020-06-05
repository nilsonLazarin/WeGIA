<?php

include("conexao.php");

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $tel = $_POST['telefone'];
    $email = $_POST['contato'];
    $tipo = $_POST['tipo'];
    $doc = $_POST['doc'];
    $dataN = $_POST['datanascimento'];

    $cep=$_POST['cep'];
    $rua=$_POST['log'];
    $numero=$_POST['numero'];
    $compl=$_POST['comp'];
    $bairro=$_POST['bairro'];
    $cidade=$_POST['cidade'];
    $uf=$_POST['uf'];

    $data = date("Y-m-d");
    $ip_log = $_SERVER['REMOTE_ADDR'];
    $horahoje = $_POST['hora'];
    $sistema = $_POST['sistema'];

    mysql_query("CALL cadDoador ('$nome', '$sobrenome', '$doc','$tel', '$dataN', '$cep', '$uf', '$cidade', '$bairro','$rua', '$numero', '$compl')");
       
?>