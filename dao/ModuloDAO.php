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
    require_once ROOT."/classes/Modulo.php";
    require_once ROOT."/Functions/funcoes.php";
    
    class ModuloDAO{
        public function alterar_modulos_visiveis($recurso){
            try{
                    $query = "UPDATE `modulos_visiveis` SET `visivel` = 0";
                    $pdo = Conexao::connect();
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                }
            catch (PDOException $e) {
                echo 'Erro: <b>  na tabela modulo_visivel = ' . $query . '</b> <br /><br />' . $e->getMessage();
            }
            try{
                foreach($recurso as $i => $id_recurso){
                    $query = "UPDATE `modulos_visiveis` SET `visivel` = 1 WHERE `id_recurso` = ".$id_recurso;
                    $pdo = Conexao::connect();
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                }
            }
            catch (PDOException $e) {
                echo 'Erro: <b>  na tabela modulo_visivel = ' . $query . '</b> <br /><br />' . $e->getMessage();
            }
        }
    }
?>