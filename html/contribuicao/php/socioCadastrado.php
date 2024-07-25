<?php
    require_once('conexao.php');

    use Versao\Conexao;
    
    $query = new Conexao();

    $doc = $_POST['doc'];

    $query -> querydados("SELECT id_pessoa FROM pessoa WHERE cpf = '$doc'");
 
        if($query -> rows() == 0)
        {
            $doc = limpaCPF_CNPJ($doc);
            $query ->querydados("SELECT id_pessoa FROM pessoa WHERE cpf = '$doc'");
                if($query -> rows() == 0)
                {
                    echo '0';
                }else{
                    $result = $query->result();
                    $id_pessoa = $result['id_pessoa'];

                    $query ->querydados("SELECT nome, sobrenome, telefone, data_nascimento, cep, estado, cidade, bairro, logradouro, numero_endereco, complemento, email FROM pessoa JOIN socio ON(pessoa.id_pessoa = socio.id_pessoa) WHERE pessoa.id_pessoa = '$id_pessoa'");
                    $result = $query->result();

                    if(verificaEndereco($result)){
                        echo (json_encode($result));
                    }else{
                        echo json_encode(['SEM_ENDERECO']);
                    }   
                }
        }else{
            $result = $query->result();
            $id_pessoa = $result['id_pessoa'];
            $query -> querydados("SELECT nome, telefone, data_nascimento, cep, estado, cidade, bairro, logradouro, numero_endereco, complemento, email FROM pessoa JOIN socio ON(pessoa.id_pessoa = socio.id_pessoa) WHERE pessoa.id_pessoa = '$id_pessoa'");
            $result = $query->result();
            if(verificaEndereco($result)){
                echo (json_encode($result));
            }else{
                echo json_encode(['SEM_ENDERECO']);
            }   
           
        }
    
        function limpaCPF_CNPJ($doc)
        {
            $doc = trim($doc);
            $doc = str_replace(".", "", $doc);
            $doc = str_replace("-", "", $doc);
            $doc = str_replace("/", "",$doc);
            return $doc;
        }

        function verificaEndereco($pessoa){
            $cep = trim($pessoa['cep']);
            $estado = trim($pessoa['estado']);
            $cidade = trim($pessoa['cidade']);
            $bairro = trim($pessoa['bairro']);
            $logradouro = trim($pessoa['logradouro']);
            $numeroEndereco = trim($pessoa['numero_endereco']);

            if(!$cep || empty($cep) || !$estado || empty($estado) || !$cidade || empty($cidade) || !$bairro || empty($bairro) || !$logradouro || empty($logradouro) || !$numeroEndereco || empty($numeroEndereco)){
                return false;
            }

            return true;
        }

/*$doc = $_POST['doc'];

$consulta = mysqli_query($conexao,"SELECT id_pessoa FROM pessoa WHERE cpf = '$doc'");
$linhas = mysqli_num_rows($consulta);

    if($linhas == 0)
    {
        $doc = limpaCPF_CNPJ($doc);
        $consulta2 = mysqli_query($conexao,"SELECT id_pessoa FROM pessoa WHERE cpf = '$doc'");
        $linhas2 = mysqli_num_rows($consulta2);
            if($linhas2 == 0)
            {
                echo "0";
            }else
                {
                $registro = mysqli_fetch_row($consulta);
                $id_pessoa = $registro[0];
              
                $dados_doador = mysqli_query($conexao, "SELECT nome, sobrenome, telefone, data_nascimento, cep, estado, cidade, bairro, logradouro, numero_endereco, complemento, email FROM pessoa JOIN socio ON(pessoa.id_pessoa = socio.id_pessoa) WHERE pessoa.id_pessoa = '$id_pessoa'");
                $dados = mysqli_fetch_row($dados_doador);
    
                $nome = $dados[0];
                //$sobrenome =  $dados[1];
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
                //$array['sobrenome']=$sobrenome;
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
    }else
        {
        $registro = mysqli_fetch_row($consulta);
        $id_pessoa = $registro[0];
    
        $dados_doador = mysqli_query($conexao, "SELECT nome, sobrenome, telefone, data_nascimento, cep, estado, cidade, bairro, logradouro, numero_endereco, complemento, email FROM pessoa JOIN socio ON(pessoa.id_pessoa = socio.id_pessoa) WHERE pessoa.id_pessoa = '$id_pessoa'");
        $dados = mysqli_fetch_row($dados_doador);

        $nome = $dados[0];
        //$sobrenome =  $dados[1];
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
        //$array['sobrenome']=$sobrenome;
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
        }*/

   
?>