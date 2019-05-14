<?php
require_once'../classes/Pessoa_epi.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';
class Pessoa_epiDAO
{

    public function incluir($pessoa_epi)
        {        
            try {

                $sql = 'call cadepi (:id_epi,:data,:epi_status)';

                $pdo = Conexao::connect();
                $sql = str_replace("'", "\'", $sql);            
                
                $stmt = $pdo->prepare($sql);

                $id_epi = $epi->getId_epi()->getId_epi();
                $data = $epi->getData();
                $epi_status = $epi->getEpi_status();

                $stmt->bindParam(':id_epi',$id_epi);
                $stmt->bindParam(':data',$data_inicio);
                $stmt->bindParam(':epi_status',$epi_status);

                $stmt->execute();
            }catch (PDOExeption $e) {
                echo 'Error: <b>  na tabela produto = ' . $sql . '</b> <br /><br />' . $e->getMessage();
            }

        }

}

?>