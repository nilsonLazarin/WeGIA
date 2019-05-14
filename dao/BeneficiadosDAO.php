<?php
require_once'../classes/Beneficiados.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';
class BeneficiadosDAO
{

    public function incluir($beneficiados)
        {        
            try {
                extract($_REQUEST);
                $pdo = Conexao::connect();

                $sql = 'call cadbeneficios (:id_beneficios,:data_inicio,:data_fim,:beneficios_status)';

                $stmt = $pdo->prepare($sql);

                $id_beneficios = $beneficios->getId_beneficios();
                $data_inicio = $beneficios->getData_inicio();
                $data_fim = $beneficios->getData_fim();
                $beneficios_status = $beneficios->getBeneficios_status();

                $stmt->bindParam(':id_beneficios',$getId_beneficios);  
                $stmt->bindParam(':data_inicio',$data_inicio);                
                $stmt->bindParam(':data_fim',$data_fim);
                $stmt->bindParam(':beneficios_status',$beneficios_status);

                $stmt->execute();
            }catch (PDOExeption $e) {
                echo 'Error: <b>  na tabela produto = ' . $sql . '</b> <br /><br />' . $e->getMessage();
            }

        }

}

?>