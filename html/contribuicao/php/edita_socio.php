<?php

    include("conexao.php");

"<br>".$nome = $_POST['nome'];
"<br>".$tel = $_POST['telefone'];
"<br>".$email = $_POST['email'];
"<br>".$doc = $_POST['doc'];
"<br>".$dataN = $_POST['datanascimento'];

"<br>".$cep=$_POST['cep'];
"<br>".$rua=$_POST['log'];
"<br>".$numero=$_POST['numero'];
"<br>".$compl=$_POST['comp'];
"<br>". $bairro=$_POST['bairro'];
"<br>".$cidade=$_POST['cidade'];
"<br>".$uf=$_POST['uf'];

    $update = mysqli_query($conexao, "UPDATE pessoa as p JOIN socio as s ON(p.id_pessoa = s.id_pessoa) SET nome = '$nome', telefone= '$tel', data_nascimento = '$dataN', cep = '$cep', logradouro = '$rua', numero_endereco = '$numero', complemento = '$compl', bairro = '$bairro', cidade = '$cidade', estado= '$uf', email = '$email' WHERE cpf = '$doc'");

?>