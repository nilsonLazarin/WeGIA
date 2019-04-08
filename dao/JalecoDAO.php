<?php
require_once'../classes/Jaleco.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';

class JalecoDAO
{
    public function incluir($jaleco)
    {        
        try {
            $pdo = Conexao::connect();

            $sql = 'INSERT jaleco(tamanhos) VALUES(:tamanhos)';
            $sql = str_replace("'", "\'", $sql);            
 
            $stmt = $pdo->prepare($sql);

            $tamanhos=$jaleco->getTamanhos();

            $stmt->bindParam(':tamanhos',$tamanhos);

            $stmt->execute();
        }catch (PDOExeption $e) {
            echo 'Error: <b>  na tabela jaleco = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
   public function listarUm($id_jaleco)
    {
        try{
            $pdo = Conexao::connect();
            $sql = "SELECT id_jaleco, tamanhos  FROM jaleco WHERE id_jaleco = :id_jaleco";
            $consulta = $pdo->prepare($sql);
            $consulta->execute(array(
                'id_jaleco' => $id_jaleco,
            ));
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $jaleco = new Jaleco($linha['tamanhos']);
                $jaleco->setId_jaleco($linha['id_jaleco']);
            }
        }catch(PDOExeption $e){
            throw $e;
        }
        return $jaleco;
    }
    public function excluir($id_jaleco){
        try{
            $pdo = Conexao::connect();
            $sql = 'DELETE FROM jaleco WHERE id_jaleco = :id_jaleco';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_jaleco',$id_jaleco);
            $stmt->execute();
            
        }catch (PDOException $e) {
                echo 'Error: <b>  na tabela jaleco = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
        public function listarTodos(){

        try{
            $jalecos=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT id_jaleco, tamanhos FROM jaleco");
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $jalecos[$x]=array('id_jaleco'=>$linha['id_jaleco'],'tamanhos'=>$linha['tamanhos']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($jalecos);
        }
}
?>