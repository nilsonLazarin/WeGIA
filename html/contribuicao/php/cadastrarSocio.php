<?php

    cadastra_socio();    

    function cadastra_socio()
    {

        require_once('conexao.php');
        $query = new Conexao;

        $nome = $_POST['nome'];
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

        $status = $_POST['status'];
        $id_tipo = $_POST['id_sociotipo'];

        //"CALL registradoacao ('$nome', '$doc','$tel', '$dataN', '$cep', '$uf', '$cidade', '$bairro','$rua', '$numero', '$compl', '$status', '$id_tipo', '$email', '$ip_log', '$data', '$horahoje', '$sistema', '$valor_doacao', '$data_vencimento')");

        $query->query("INSERT INTO pessoa(nome,cpf,telefone,data_nascimento,cep,estado,cidade, bairro, logradouro, numero_endereco,complemento) VALUES ('$nome', '$doc','$tel', '$dataN', '$cep', '$uf', '$cidade', '$bairro','$rua', '$numero', '$compl')");

        $query->query("INSERT INTO socio(id_pessoa, id_sociostatus, id_sociotipo, email)values ((SELECT id_pessoa FROM pessoa WHERE pessoa.cpf='$doc'), '$status','$id_tipo', '$email')");
    }



?>