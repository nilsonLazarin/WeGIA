<?php

   require_once('conexao.php');
   $query = new Conexao();

    $nome = $_POST['nome'];
    $tel = $_POST['telefone'];
    $email = $_POST['email'];
    $doc = $_POST['doc'];
    $dataN = $_POST['datanascimento'];

    $cep=$_POST['cep'];
    $rua=$_POST['log'];
    $numero=$_POST['numero'];
    $compl=$_POST['comp'];
    $bairro=$_POST['bairro'];
    $cidade=$_POST['cidade'];
    $uf=$_POST['uf'];

   $query->query("UPDATE pessoa as p JOIN socio as s ON(p.id_pessoa = s.id_pessoa) SET nome = '$nome', telefone= '$tel', data_nascimento = '$dataN', cep = '$cep', logradouro = '$rua', numero_endereco = '$numero', complemento = '$compl', bairro = '$bairro', cidade = '$cidade', estado= '$uf', email = '$email' WHERE cpf = '$doc'");

?>