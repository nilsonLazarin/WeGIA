<?php
require_once '../classes/Almoxarifado.php';
require_once 'Conexao.php';
require_once '../Functions/funcoes.php';

class AlmoxarifadoDAO
{
    public function incluir($almoxarifado)
    {        
        try {
            $pdo = Conexao::connect();

            $sql = 'INSERT almoxarifado(descricao_almoxarifado) VALUES(:descricao_almoxarifado)';
            $sql = str_replace("'", "\'", $sql);
 
            $stmt = $pdo->prepare($sql);

            $descricao_almoxarifado=$almoxarifado->getDescricao_almoxarifado();

            $stmt->bindParam(':descricao_almoxarifado',$descricao_almoxarifado);

            $stmt->execute();
        }catch (PDOExeption $e) {
            echo 'Error: <b>  na tabela almoxarifado = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
   public function listarUm($id_almoxarifado)
    {
        try{
            $pdo = Conexao::connect();
            $sql = "SELECT id_almoxarifado, descricao_almoxarifado  FROM almoxarifado WHERE id_almoxarifado = :id_almoxarifado";
            $consulta = $pdo->prepare($sql);
            $consulta->execute(array(
                'id_almoxarifado' => $id_almoxarifado,
            ));
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $almoxarifado = new Almoxarifado($linha['descricao_almoxarifado']);
                $almoxarifado->setId_almoxarifado($linha['id_almoxarifado']);
            }
        }catch(PDOExeption $e){
            throw $e;
        }
        return $almoxarifado;
    }
    public function excluir($id_almoxarifado){
        try{
            $pdo = Conexao::connect();
            $sql = 'DELETE FROM almoxarifado WHERE id_almoxarifado = :id_almoxarifado';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_almoxarifado',$id_almoxarifado);
            $stmt->execute();
            
        }catch (PDOException $e) {
                echo 'Error: <b>  na tabela almoxarifado = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
        public function listarTodos(){

        try{
            $almoxarifados=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT id_almoxarifado, descricao_almoxarifado FROM almoxarifado");
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $almoxarifados[$x]=array('id_almoxarifado'=>$linha['id_almoxarifado'],'descricao_almoxarifado'=>$linha['descricao_almoxarifado']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($almoxarifados);
        }
}
?>