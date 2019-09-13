<?php
require_once'../classes/Pessoa_epi.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';
class Pessoa_epiDAO
{

    public function incluir($epi)
        {        
            try {

                $sql = 'call cadepi(:id_epi,:data,:epi_status)';
                $pdo = Conexao::connect();
                $sql = str_replace("'", "\'", $sql);            
                $stmt = $pdo->prepare($sql);

                $id_epi = $epi->getId_epi();
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

        public function alterarEpi($epis){
            try {
                $sql = 'UPDATE pessoa_epi AS pe INNER JOIN pessoa AS p ON pe.id_pessoa=p.id_pessoa INNER JOIN funcionario AS f ON p.id_pessoa=f.id_pessoa SET id_epi=:id_epi, data=:data, epi_status=:epi_status WHERE f.id_funcionario = :id_funcionario';

                $sql = str_replace("'", "\'", $sql);            
                $pdo = Conexao::connect();
                $stmt = $pdo->prepare($sql);

                $id_pessoa = $epis->getId_pessoa();
                $id_epi = $epis->getId_epi();
                $epi_status = $epis->getEpi_status();
                $data = $epis->getData();
                
                $stmt->bindParam(':id_funcionario',$id_pessoa);
                $stmt->bindParam(':id_epi',$id_epi);                 
                $stmt->bindParam(':epi_status',$epi_status);
                $stmt->bindParam(':data',$data); 

                $stmt->execute();
            }catch (PDOExeption $e) {
                echo 'Error: <b>  na tabela Pessoa_Epi = ' . $sql . '</b> <br /><br />' . $e->getMessage();
            }
        }

}

?>