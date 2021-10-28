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

class SaudeDAO
{
    public function incluir($saude)
    {               
        try {
            $sql = "call cadfichamedica(:nome,:descricao)";
            //$sql = str_replace("'", "\'", $sql); 
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            $nome=$saude->getNome();
            $descricao=$saude->getTexto();
            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':descricao',$descricao);
            $stmt->execute();
            $pdo->commit();
            $pdo->close();
            
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
        
        
    }
    public function listarTodos(){

        try{
            $pacientes=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT p.nome,s.descricao,p.sobrenome FROM pessoa p INNER JOIN saude_fichamedica s ON s.id_pessoa = p.id_pessoa");
            // $produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
            
                $pacientes[$x]=array('nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'descricao'=>$linha['descricao']);
                $x++;
            }
            //$pdo->commit();
            //$pdo->close();
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($pacientes);
    }

}
