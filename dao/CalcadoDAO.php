<?php
require_once'../classes/Calcado.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';

class CalcadoDAO
{
    public function incluir($calcado)
    {        
        try {
            $pdo = Conexao::connect();

            $sql = 'INSERT calcado(tamanhos) VALUES(:tamanhos)';
            $sql = str_replace("'", "\'", $sql);            
 
            $stmt = $pdo->prepare($sql);

            $tamanhos=$calcado->getTamanhos();

            $stmt->bindParam(':tamanhos',$tamanhos);

            $stmt->execute();
        }catch (PDOExeption $e) {
            echo 'Error: <b>  na tabela calcado = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
   public function listarUm($id_calcado)
    {
        try{
            $pdo = Conexao::connect();
            $sql = "SELECT id_calcado, tamanhos  FROM calcado WHERE id_calcado = :id_calcado";
            $consulta = $pdo->prepare($sql);
            $consulta->execute(array(
                'id_calcado' => $id_calcado,
            ));
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $calcado = new Calcado($linha['tamanhos']);
                $calcado->setId_calcado($linha['id_calcado']);
            }
        }catch(PDOExeption $e){
            throw $e;
        }
        return $calcado;
    }
    public function excluir($id_calcado){
        try{
            $pdo = Conexao::connect();
            $sql = 'DELETE FROM calcado WHERE id_calcado = :id_calcado';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_calcado',$id_calcado);
            $stmt->execute();
            
        }catch (PDOException $e) {
                echo 'Error: <b>  na tabela calcado = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
        public function listarTodos(){

        try{
            $calcados=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT id_calcado, tamanhos FROM calcado");
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $calcados[$x]=array('id_calcado'=>$linha['id_calcado'],'tamanhos'=>$linha['tamanhos']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($calcados);
        }
}
?>