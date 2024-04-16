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
require_once ROOT.'/classes/Beneficiados.php';
require_once ROOT.'/Functions/funcoes.php';
class BeneficiadosDAO
{
  public function formatoDataDMY($data)
    {
        if ($data){
            $data_arr = explode("-", $data);
            
            $datad = $data_arr[2] . '/' . $data_arr[1] . '/' . $data_arr[0];
            
            return $datad;
        }
        return "Sem Data";
    }

    public function incluir($beneficiados){        
      try {

          $sql = 'call cadbeneficiados(:id_pessoa,:id_beneficios,:data_inicio,:data_fim,:beneficios_status,:valor)';
          $sql = str_replace("'", "\'", $sql);
          $pdo = Conexao::connect();
          $stmt = $pdo->prepare($sql);

          $ibeneficios=$beneficiados->getId_beneficios();
          $data_inicio=$beneficiados->getData_inicio();
          $data_fim=$beneficiados->getData_fim();
          $beneficios_status=$beneficiados->getBeneficios_status();
          $valor=$beneficiados->getValor();
          $pessoa=$beneficiados->getId_pessoa();

          $stmt->bindParam(':id_beneficios',$ibeneficios);  
          $stmt->bindParam(':data_inicio',$data_inicio);                
          $stmt->bindParam(':data_fim',$data_fim);
          $stmt->bindParam(':beneficios_status',$beneficios_status);
          $stmt->bindParam(':valor',$valor);
          $stmt->bindParam(':id_pessoa',$pessoa);

          $stmt->execute();
      }catch (PDOException $e) {
          echo 'Error: <b>  na tabela Beneficiados = ' . $sql . '</b> <br /><br />' . $e->getMessage();
      }
    }

    //alterar
    public function alterarBeneficiados($beneficiados){
      try {
            $sql = 'UPDATE beneficiados AS b INNER JOIN pessoa AS p ON b.id_pessoa=p.id_pessoa INNER JOIN funcionario AS f ON p.id_pessoa=f.id_pessoa SET id_beneficios=:id_beneficios, data_inicio=:data_inicio, data_fim=:data_fim, beneficios_status=:beneficios_status, valor=:valor WHERE f.id_funcionario = :id_funcionario';

            $sql = str_replace("'", "\'", $sql);            
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            $id_pessoa = $beneficiados->getId_pessoa();
            $id_beneficios = $beneficiados->getId_beneficios();
            $data_inicio = $beneficiados->getData_inicio();
            $data_fim = $beneficiados->getData_fim();
            $beneficios_status = $beneficiados->getBeneficios_status();
            $valor = $beneficiados->getValor();

            $stmt->bindParam(':id_funcionario',$id_pessoa);
            $stmt->bindParam(':id_beneficios',$id_beneficios);  
            $stmt->bindParam(':data_inicio',$data_inicio);                
            $stmt->bindParam(':data_fim',$data_fim);
            $stmt->bindParam(':beneficios_status',$beneficios_status);
            $stmt->bindParam(':valor',$valor);

            $stmt->execute();
      }catch (PDOException $e) {
          echo 'Error: <b>  na tabela Beneficiados = ' . $sql . '</b> <br /><br />' . $e->getMessage();
      }
    }

    // excluir
    public function excluir($id_beneficiados)
    {
        try {
            $sql = 'delete b from funcionario as f inner join pessoa as p on p.id_pessoa=f.id_pessoa inner join beneficiados as b on p.id_pessoa=b.id_pessoa where b.id_beneficiados=:id_beneficiados';
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':id_beneficiados', $id_beneficiados);
            
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela beneficiados = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function listarBeneficio($id_funcionario){
        try{
            $pdo = Conexao::connect();
            $sql = "SELECT f.id_funcionario,b.id_beneficiados,b.data_inicio,b.data_fim,b.beneficios_status,b.valor,be.id_beneficios,be.descricao_beneficios FROM pessoa p INNER JOIN funcionario f ON p.id_pessoa = f.id_pessoa LEFT JOIN beneficiados b ON b.id_pessoa = p.id_pessoa LEFT JOIN beneficios be ON be.id_beneficios = b.id_beneficios WHERE f.id_funcionario = :id_funcionario";
           

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_funcionario',$id_funcionario);

            $stmt->execute();
            $beneficio=array();

            while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
                var_dump($linha);
                $beneficio[] = array(
                    'id_funcionario'=>$linha['id_funcionario'] ? $linha['id_funcionario'] : null,
                    'id_beneficiados'=>$linha['id_beneficiados'] ? $linha['id_beneficiados'] : "Nenhum",
                    'data_inicio'=>$this->formatoDataDMY($linha['data_inicio']),
                    'data_fim'=>$this->formatoDataDMY($linha['data_fim']),
                    'beneficios_status'=>$linha['beneficios_status'] ? $linha['beneficios_status'] : "Nenhum",
                    'valor'=>$linha['valor'] ? $linha['valor'] : "",
                    'id_beneficios'=>$linha['id_beneficios'] ? $linha['id_beneficios'] : null,
                    'descricao_beneficios'=>$linha['descricao_beneficios'] ? $linha['descricao_beneficios'] : "Nenhum"
                );
            }
        }catch (PDOException $e){
            echo 'Error: ' .  $e->getMessage();
        }
        return json_encode($beneficio);
    }

}

?>