<?php

class EnderecoDAO
{
public function alterarEndereco($endereco)
    {
        var_dump($endereco);
        try {
            $sql = 'call insendereco_inst(:nome,:numero_endereco,:logradouro,:bairro,:cidade,:estado,:cep,:complemento,:ibge)';
            
            $sql = str_replace("'", "\'", $sql);

            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            $nome=$endereco->getNome();
            $cep=$endereco->getCep();
            $estado=$endereco->getEstado();
            $cidade=$endereco->getCidade();
            $bairro=$endereco->getBairro();
            $logradouro=$endereco->getLogradouro();
            $numero_endereco=$endereco->getNumeroEndereco();        
            $complemento=$endereco->getComplemento();
            $ibge=$endereco->getIbge();

            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':cep',$cep);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':cidade',$cidade);
            $stmt->bindParam(':bairro',$bairro);
            $stmt->bindParam(':logradouro',$logradouro);
            $stmt->bindParam(':numero_endereco',$numero_endereco);        
            $stmt->bindParam(':complemento',$complemento);
            $stmt->bindParam(':ibge',$ibge);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
}
?>