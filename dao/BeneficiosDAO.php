<?php
require_once'../classes/Beneficios.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';

class BeneficiosDAO
{
	public function incluir($beneficios){
        try{
            extract($_REQUEST);
            $pdo = Conexao::connect();

            $sql = 'INSERT beneficios(id_beneficios,descricao_beneficios) VALUES( :id_beneficios,:descricao_beneficios)';
            $sql = str_replace("'", "\'", $sql);            
            $stmt = $pdo->prepare($sql);
            
            $id_beneficios = $beneficios->getId_beneficiados();
            $descricao_beneficios = $beneficios->get_descricao();

            $stmt->bindParam(':id_beneficios',$id_beneficios);
            $stmt->bindParam(':descricao_beneficios',$descricao_beneficios);

            $stmt->execute();
        } catch(PDOExeption $e){
            echo 'Error: <b>  na tabela produto = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }

    }
}
?>
