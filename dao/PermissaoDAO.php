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
    require_once ROOT."/classes/Funcionario.php";
    require_once ROOT."/Functions/funcoes.php";
    
    class PermissaoDAO{
        public function adicionarPermissao($cargo, $acao, $recurso){
            try {
                if(count($recurso > 1)){
                    foreach($recurso as $i => $recurso_id){
                        $query = "INSERT INTO `permissao` (`id_cargo`, `id_acao`, `id_recurso`) VALUES ('$cargo', '$acao', '$recurso_id')";
                        $pdo = Conexao::connect();
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                    }
                }else{
                        $recurso_id = $recurso[0];
                        $query = "INSERT INTO `permissao` (`id_cargo`, `id_acao`, `id_recurso`) VALUES ('$cargo', '$acao', '$recurso_id')";
                        $pdo = Conexao::connect();
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                }
            } catch (PDOException $e) {
                echo 'Erro: <b>  na tabela permissao = ' . $query . '</b> <br /><br />' . $e->getMessage();
            }
        }
    }
?>