<?php
require_once "/var/www/html/WeGIA/dao/Conexao.php";
require_once $caminho.'classes/Pessoa_epi.php';
require_once $caminho.'Functions/funcoes.php';
class Pessoa_epiDAO
{

    public function incluir($epi){        
        try {

            $sql = 'call cadepi(:id_epi,:data,:epi_status)';
            $pdo = Conexao::connect();
            $sql = str_replace("'", "\'", $sql);            
            $stmt = $pdo->prepare($sql);

            $id_epi = $epi->getId_epi();
            $data = $epi->getData();
            $epi_status = $epi->getEpi_status();

            $stmt->bindParam(':id_epi',$id_epi);
            $stmt->bindParam(':data',$data);
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
        // excluir
    public function excluir($id_pessoa_epi)
    {
        try {
            $sql = 'delete pe from funcionario as f inner join pessoa as p on p.id_pessoa=f.id_pessoa inner join pessoa_epi as pe on p.id_pessoa=pe.id_pessoa where pe.id_pessoa_epi=:id_pessoa_epi';
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':id_pessoa_epi', $id_pessoa_epi);
            
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela epi = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function listarEpi($id_funcionario){
        try{
            $pdo = Conexao::connect();
            $sql = "SELECT f.id_funcionario,pe.id_pessoa_epi,pe.data,pe.epi_status,e.id_epi, e.descricao_epi FROM pessoa p INNER JOIN funcionario f ON p.id_pessoa = f.id_pessoa LEFT JOIN pessoa_epi pe ON pe.id_pessoa = f.id_pessoa LEFT JOIN epi e ON e.id_epi = pe.id_epi WHERE f.id_funcionario = :id_funcionario";
           

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_funcionario',$id_funcionario);

            $stmt->execute();
            $epi=array();

            while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
                $epi[] = array('id_funcionario'=>$linha['id_funcionario'],'id_pessoa_epi'=>$linha['id_pessoa_epi'],'data'=>$linha['data'],'epi_status'=>$linha['epi_status'],'id_epi'=>$linha['id_epi'], 'descricao_epi'=>$linha['descricao_epi']);
            }
        }catch (PDOExeption $e){
            echo 'Error: ' .  $e->getMessage();
        }
        return json_encode($epi);
    }
}

?>