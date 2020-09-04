<?php

    include("conexao.php");

$doc = $_POST['doc'];

$consulta = mysqli_query($conexao,"SELECT id_pessoa FROM pessoa WHERE cpf = '$doc'");
$linhas = mysqli_num_rows($consulta);

    if($linhas == 0)
    {
        echo $linhas;
    }else
        {
            $registro = mysqli_fetch_row($consulta);
            $id_pessoa = $registro[0];
          
            $dados_doador = mysqli_query($conexao, "SELECT nome, sobrenome, telefone, data_nascimento, cep, estado, cidade, bairro, logradouro, numero_endereco, complemento, email FROM pessoa JOIN socio ON(pessoa.id_pessoa = socio.id_pessoa) WHERE pessoa.id_pessoa = '$id_pessoa'");
            $dados = mysqli_fetch_row($dados_doador);

            $nome = $dados[0];
            $sobrenome =  $dados[1];
            $tel =  $dados[2]; 
            $dataN = $dados[3];
            $cep = $dados[4];
            $uf = $dados[5];
            $cidade = $dados[6];
            $bairro = $dados[7];
            $rua = $dados[8];
            $numero = $dados[9];
            $compl = $dados[10];
            $email = $dados[11];

            $array['nome'] = $nome;
            $array['sobrenome']=$sobrenome;
            $array['tel']=$tel;
            $array['data_n']=$dataN;
            $array['cep']=$cep;
            $array['uf']=$uf;
            $array['cidade']=$cidade;
            $array['bairro']=$bairro;
            $array['rua']=$rua;
            $array['numero']=$numero;
            $array['compl']=$compl;
            $array['email']=$email;

            echo (json_encode($array));
        }
?>