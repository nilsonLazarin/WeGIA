<?php
require_once'../classes/Beneficiados.php';;
require_once'Conexao.php';
require_once'../Functions/funcoes.php';
class BeneficiadosDAO
{

    public function incluir($beneficiados){        
      try {

          $sql = 'call cadbeneficiados(:id_beneficios,:data_inicio,:data_fim,:beneficios_status)';
          $sql = str_replace("'", "\'", $sql);
          $pdo = Conexao::connect();
          $stmt = $pdo->prepare($sql);

          $ibeneficios=$beneficiados->getId_beneficios();
          $data_inicio=$beneficiados->getData_inicio();
          $data_fim=$beneficiados->getData_fim();
          $beneficios_status=$beneficiados->getBeneficios_status();

          $stmt->bindParam(':id_beneficios',$ibeneficios);  
          $stmt->bindParam(':data_inicio',$data_inicio);                
          $stmt->bindParam(':data_fim',$data_fim);
          $stmt->bindParam(':beneficios_status',$beneficios_status);

          $stmt->execute();
      }catch (PDOExeption $e) {
          echo 'Error: <b>  na tabela Beneficiados = ' . $sql . '</b> <br /><br />' . $e->getMessage();
      }
    }

    public function alterarBeneficiados($beneficiados){
      try {
            $sql = 'UPDATE beneficiados AS b INNER JOIN pessoa AS p ON b.id_pessoa=p.id_pessoa INNER JOIN funcionario AS f ON p.id_pessoa=f.id_pessoa SET id_beneficios=:id_beneficios, data_inicio=:data_inicio, data_fim=:data_fim, beneficios_status=:beneficios_status WHERE f.id_funcionario = :id_funcionario';

            $sql = str_replace("'", "\'", $sql);            
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            $id_pessoa = $beneficiados->getId_pessoa();
            $id_beneficios = $beneficiados->getId_beneficios();
            $data_inicio = $beneficiados->getData_inicio();
            $data_fim = $beneficiados->getData_fim();
            $beneficios_status = $beneficiados->getBeneficios_status();

            $stmt->bindParam(':id_funcionario',$id_pessoa);
            $stmt->bindParam(':id_beneficios',$id_beneficios);  
            $stmt->bindParam(':data_inicio',$data_inicio);                
            $stmt->bindParam(':data_fim',$data_fim);
            $stmt->bindParam(':beneficios_status',$beneficios_status);

            $stmt->execute();
      }catch (PDOExeption $e) {
          echo 'Error: <b>  na tabela Beneficiados = ' . $sql . '</b> <br /><br />' . $e->getMessage();
      }
    }

}

?>