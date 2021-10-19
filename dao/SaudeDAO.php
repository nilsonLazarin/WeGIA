<?php

$config_path = "config.php";
if(file_exists($config_path)){
    require_once($config_path);
}else{
    while(true){
        $config_path = "../" . $config_path;
        if(file_exists($config_path)) break;
    }
    require_once($config_path);
}
require_once ROOT."/dao/Conexao.php";
require_once ROOT."/classes/Saude.php";
require_once ROOT."/Functions/funcoes.php";

class AtendidoDAO
{
    public function incluir($atendido)
    {               
        try {
            $sql = "call cadatendido(:strNome,:strSobrenome,:strCpf,:strSexo,:strTelefone,:dateNascimento, :intStatus, :intTipo)";
            //$sql = str_replace("'", "\'", $sql); 
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            
            $nome=$atendido->getNome();
            $sobrenome=$atendido->getSobrenome();
            $cpf=$atendido->getCpf();
            $sexo=$atendido->getSexo();
            $telefone=$atendido->getTelefone();
            $dataNascimento=$atendido->getDataNascimento();
            $intTipo=$atendido->getIntTipo();
            $intStatus=$atendido->getIntStatus();

            $stmt->bindParam(':strNome',$nome);
            $stmt->bindParam(':strSobrenome',$sobrenome);
            $stmt->bindParam(':strCpf',$cpf);
            $stmt->bindParam(':strSexo',$sexo);
            $stmt->bindParam(':strTelefone',$telefone);
            $stmt->bindParam(':dateNascimento',$dataNascimento);
            $stmt->bindParam(':intStatus',$intStatus);
            $stmt->bindParam(':intTipo',$intTipo);
            $stmt->execute();
            $pdo->commit();
            $pdo->close();
            

            //$pdo = Conexao::flush();
            //$pdo = Conexao::close();

            
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
        
        
    }
}