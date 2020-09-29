<?php

include("conexao.php");

    "<br>". $nome = $_POST['nome'];
    "<br>".$tel = $_POST['telefone'];
    "<br>".$email = $_POST['contato'];
    "<br>".$tipo = $_POST['tipo'];
    "<br>".$doc = $_POST['doc'];
    "<br>".$dataN = $_POST['datanascimento'];

    "<br>".$cep=$_POST['cep'];
    "<br>".$rua=$_POST['log'];
    "<br>".$numero=$_POST['numero'];
    "<br>".$compl=$_POST['comp'];
    "<br>". $bairro=$_POST['bairro'];
    "<br>".$cidade=$_POST['cidade'];
    "<br>".$uf=$_POST['uf'];

    "<br>".$data = date("Y-m-d");
    "<br>".$ip_log = $_SERVER['REMOTE_ADDR'];
    "<br>".$horahoje = $_POST['hora'];
    "<br>".$sistema = $_POST['sistema'];
    "<br>".$status = $_POST['status'];
    "<br>".$id_tipo = $_POST['id_sociotipo'];

    $valor_doacao = $_POST['valor_doacao'];
    "<br>".$data_vencimento = $_POST['datavencimento'];
    
    //mysqli_query($conexao, "CALL registradoacao ('$nome', '$doc','$tel', '$dataN', '$cep', '$uf', '$cidade', '$bairro','$rua', '$numero', '$compl', '$status', '$id_tipo', '$email', '$ip_log', '$data', '$horahoje', '$sistema', '$valor_doacao', '$data_vencimento')");

    mysqli_query($conexao, "INSERT INTO pessoa(nome,cpf,telefone,data_nascimento,cep,estado,cidade, bairro, logradouro, numero_endereco,complemento) VALUES ('$nome', '$doc','$tel', '$dataN', '$cep', '$uf', '$cidade', '$bairro','$rua', '$numero', '$compl')");

    mysqli_query($conexao, "INSERT INTO socio(id_pessoa, id_sociostatus, id_sociotipo, email)values ((SELECT id_pessoa FROM pessoa WHERE pessoa.cpf='$doc'), '$status','$id_tipo', '$email')");

?>