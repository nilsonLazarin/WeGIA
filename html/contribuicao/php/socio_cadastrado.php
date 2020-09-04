<?php

    include("conexao.php");

$doc = $_POST['cpfcnpj'];
$data_n = $_POST['data_n'];

$consulta = mysqli_query($conexao, "SELECT id_pessoa FROM pessoa WHERE cpf = '$doc' AND data_nascimento = '$data_n'");
$linhas = mysqli_num_rows($consulta);

    if($linhas == 0)
    {
        return false;
    }else
        {
            return true;
        }
?>