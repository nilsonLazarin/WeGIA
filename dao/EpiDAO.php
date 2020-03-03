<?php
require_once'../classes/Epi.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';

class EpiDAO
{
	public function incluir($epi){
        try{
            extract($_REQUEST);
            $pdo = Conexao::connect();

            $sql = 'INSERT epi(id_epi,descricao_epi) VALUES( :id_epi,:descricao_epi)';
            $sql = str_replace("'", "\'", $sql);            
            $stmt = $pdo->prepare($sql);
            
            $id_epi = $epi->getId_beneficiados();
            $descricao_epi = $epi->get_descricao();

            $stmt->bindParam(':id_epi',$id_epi);
            $stmt->bindParam(':descricao_epi',$descricao_epi);

            $stmt->execute();
        } catch(PDOExeption $e){
            echo 'Error: <b>  na tabela produto = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }

    }
}
?>
