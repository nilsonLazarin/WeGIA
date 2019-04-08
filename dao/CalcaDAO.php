<?php
require_once'../classes/Calca.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';

class CalcaDAO
{
    public function incluir($calca)
    {        
        try {
            $pdo = Conexao::connect();

            $sql = 'INSERT calca(tamanhos) VALUES(:tamanhos)';
            $sql = str_replace("'", "\'", $sql);            
 
            $stmt = $pdo->prepare($sql);

            $tamanhos=$calca->getTamanhos();

            $stmt->bindParam(':tamanhos',$tamanhos);

            $stmt->execute();
        }catch (PDOExeption $e) {
            echo 'Error: <b>  na tabela calca = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
   public function listarUm($id_calca)
    {
        try{
            $pdo = Conexao::connect();
            $sql = "SELECT id_calca, tamanhos  FROM calca WHERE id_calca = :id_calca";
            $consulta = $pdo->prepare($sql);
            $consulta->execute(array(
                'id_calca' => $id_calca,
            ));
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $calca = new Calca($linha['tamanhos']);
                $calca->setId_calca($linha['id_calca']);
            }
        }catch(PDOExeption $e){
            throw $e;
        }
        return $calca;
    }
    public function excluir($id_calca){
        try{
            $pdo = Conexao::connect();
            $sql = 'DELETE FROM calca WHERE id_calca = :id_calca';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_calca',$id_calca);
            $stmt->execute();
            
        }catch (PDOException $e) {
                echo 'Error: <b>  na tabela calca = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
        public function listarTodos(){

        try{
            $calcas=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT id_calca, tamanhos FROM calca");
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $calcas[$x]=array('id_calca'=>$linha['id_calca'],'tamanhos'=>$linha['tamanhos']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($calcas);
        }
}
?>