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

    /**
     * Recebe dois parâmetros, o id da ficha médica e um array com as strings de texto que formaram o novo conteúdo, acessa o banco de dados e realiza as alterações necessárias no campo descricao da tabela saude_fichamedica_descricoes
     */
    public function alterar($idFicha, $texto){
        try{
            $sql1 = "SELECT id_descricao FROM saude_fichamedica_descricoes WHERE id_fichamedica = $idFicha";
            $sql2 = "UPDATE saude_fichamedica_descricoes SET descricao =:descricao WHERE id_descricao =:id";
            $sql3 = "DELETE FROM saude_fichamedica_descricoes WHERE id_descricao=:id";
            $sql4 = "INSERT INTO saude_fichamedica_descricoes(id_fichamedica, descricao) VALUES (:id, :descricao)";
            $pdo = Conexao::connect();
            //$pdo->beginTransaction();
            $stmt = $pdo->prepare($sql1);
            $stmt->execute();
            $descricoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($descricoes as $indice =>$descricao){
                //Adicionar verificação para atribuir uma descrição vazia a partir do momento que o indice passar do número de elementos do texto
                if($texto[$indice]){
                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->bindParam(':descricao', $texto[$indice]);
                    $stmt2->bindParam(':id', $descricao['id_descricao']);
    
                    $stmt2->execute();
                }else{
                    //echo 'Array Vazio<br>';
                    $stmt3 = $pdo->prepare($sql3);
                    $stmt3->bindParam(':id', $descricao['id_descricao']);

                    $stmt3->execute();
                }

            }

            //echo $indice;
            //Adicionar verificação para detectar se todo o texto enviado foi de fato alterado, em caso negativo fazer um INSERT INTO com o conteúdo restante.
            $tamanhoTexto = count(($texto));
            if($tamanhoTexto > $indice){

                for($i=++$indice; $i<$tamanhoTexto; $i++){
                    //echo $i.'<br>';
                    $stmt4 = $pdo->prepare($sql4);
                    $stmt4->bindParam(':id', $idFicha);
                    $stmt4->bindParam(':descricao', $texto[$i]);

                    $stmt4->execute();
                }
            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }
       
    }
}


?>