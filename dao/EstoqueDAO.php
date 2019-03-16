 <?php
require_once'../classes/Estoque.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';

class EstoqueDAO
{
        public function listarTodos(){

        try{
            $Estoques=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT p.descricao,a.descricao_almoxarifado,e.qtd FROM produto p INNER JOIN estoque e ON p.id_produto = e.id_produto
                    INNER JOIN almoxarifado a ON a.id_almoxarifado = e.id_almoxarifado");
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $Estoques[$x]=array('descricao'=>$linha['descricao'],'descricao_almoxarifado'=>$linha['descricao_almoxarifado'],'qtd'=>$linha['qtd']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($Estoques);
        }
}
?>