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

class DescricaoDAO{
    public function incluir($texto, $id_pessoa){
        try{
            $query = "SELECT `id_fichamedica` FROM `saude_fichamedica` WHERE `id_pessoa` = ".$id_pessoa;
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            echo 'Erro: <b>  na tabela saude_fichamedica = ' . $query . '</b> <br /><br />' . $e->getMessage();
        }
        $id_fichamedica= $result['id_fichamedica'];
        foreach($texto as $txt){
            try{
                $query = "INSERT INTO `saude_fichamedica_descricoes` (`id_fichamedica`, `descricao`) VALUES (:id_fichamedica, :descricao)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':id_fichamedica', $id_fichamedica);
                $stmt->bindParam(':descricao', $txt);
                $stmt->execute();
            }
            catch (PDOException $e) {
                echo 'Erro: <b>  na tabela saude_fichamedica_descricao = ' . $query . '</b> <br /><br />' . $e->getMessage();
            }
            
        }
    }
}


?>