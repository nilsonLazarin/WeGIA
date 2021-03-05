 <?php
require_once '../classes/Estoque.php';
require_once 'Conexao.php';
require_once '../Functions/funcoes.php';
require_once '../Functions/permissao/permissao.php';

class EstoqueDAO
{
        public function listarTodos(){

        try{
            $Estoques=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("
                SELECT p.descricao, p.codigo, a.descricao_almoxarifado, e.qtd, c.descricao_categoria as categoria, a.id_almoxarifado 
                FROM produto p 
                INNER JOIN estoque e ON p.id_produto = e.id_produto
                INNER JOIN almoxarifado a ON a.id_almoxarifado = e.id_almoxarifado 
                INNER JOIN categoria_produto c ON p.id_categoria_produto = c.id_categoria_produto
                WHERE e.qtd != 0 AND p.oculto = false
                ORDER BY p.descricao;");
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $Estoques[$x]=array('codigo'=>$linha['codigo'],'descricao'=>$linha['descricao'],'descricao_almoxarifado'=>$linha['descricao_almoxarifado'],'qtd'=>$linha['qtd'],'categoria'=>$linha['categoria'],'id_almoxarifado'=>$linha['id_almoxarifado']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return filtrarAlmoxarifado($_SESSION['id_pessoa'] , json_encode($Estoques));
        }
}
?>