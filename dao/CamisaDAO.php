<?php
require_once'../classes/Camisa.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';

class CamisaDAO
{
    public function incluir($camisa)
    {        
        try {
            $pdo = Conexao::connect();

            $sql = 'INSERT camisa(tamanhos) VALUES(:tamanhos)';
            $sql = str_replace("'", "\'", $sql);            
 
            $stmt = $pdo->prepare($sql);

            $tamanhos=$camisa->getTamanhos();

            $stmt->bindParam(':tamanhos',$tamanhos);

            $stmt->execute();
        }catch (PDOExeption $e) {
            echo 'Error: <b>  na tabela camisa = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
   public function listarUm($id_camisa)
    {
        try{
            $pdo = Conexao::connect();
            $sql = "SELECT id_camisa, tamanhos  FROM camisa WHERE id_camisa = :id_camisa";
            $consulta = $pdo->prepare($sql);
            $consulta->execute(array(
                'id_camisa' => $id_camisa,
            ));
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $camisa = new Camisa($linha['tamanhos']);
                $camisa->setId_camisa($linha['id_camisa']);
            }
        }catch(PDOExeption $e){
            throw $e;
        }
        return $camisa;
    }
    public function excluir($id_camisa){
        try{
            $pdo = Conexao::connect();
            $sql = 'DELETE FROM camisa WHERE id_camisa = :id_camisa';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_camisa',$id_camisa);
            $stmt->execute();
            
        }catch (PDOException $e) {
                echo 'Error: <b>  na tabela camisa = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
        public function listarTodos(){

        try{
            $camisas=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT id_camisa, tamanhos FROM camisa");
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $camisas[$x]=array('id_camisa'=>$linha['id_camisa'],'tamanhos'=>$linha['tamanhos']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($camisas);
        }
}
?>