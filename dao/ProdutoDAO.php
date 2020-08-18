<?php
require_once '../classes/Produto.php';
require_once 'Conexao.php';
require_once '../Functions/funcoes.php';
class ProdutoDAO
{
	public function incluir($produto)
	    {        
	        try {
	        	$pdo = Conexao::connect();
				$existente = $pdo->query("SELECT id_produto, oculto FROM produto WHERE descricao='".$produto->getDescricao()."'")->fetch(PDO::FETCH_ASSOC);
				$existente['oculto'] = intval($existente['oculto']);
				if ($existente){
					// Caso já exista
					if ($existente['oculto']){
						// Caso já exista e esteja oculto
						header("Location: ../html/restaurar_produto.php?id_produto=".$existente['id_produto']);
					}else{
						echo("Location: ../html/cadastro_produto.php?flag=warn&msg=A descrição inserida já existe!");
					}
				}else{
					$sql = 'INSERT produto(id_categoria_produto,id_unidade,descricao,codigo,preco) VALUES( :id_categoria_produto,:id_unidade,:descricao,:codigo,:preco)';
					$sql = str_replace("'", "\'", $sql);            
					
					$stmt = $pdo->prepare($sql);
	
					$id_categoria_produto = $produto->get_categoria_produto()->getId_categoria_produto();
					$id_unidade=$produto->get_unidade()->getId_unidade();
					$descricao=$produto->getDescricao();
					$codigo=$produto->getCodigo();
					$preco=$produto->getPreco();
					
					$descricao = preg_replace('/( )+/', ' ', trim($descricao));
	
					$stmt->bindParam(':id_categoria_produto',$id_categoria_produto);
					$stmt->bindParam(':id_unidade',$id_unidade);	            
					$stmt->bindParam(':descricao',$descricao);
					$stmt->bindParam(':codigo',$codigo);
					$stmt->bindParam(':preco',$preco);
	
					$stmt->execute();
				}

	        }catch (PDOExeption $e) {
	            echo 'Error: <b>  na tabela produto = ' . $sql . '</b> <br /><br />' . $e->getMessage();
	        }

	    }

	        public function excluir($id_produto)
		    {
				$sql = 'DELETE FROM produto WHERE id_produto = :id_produto';
				try{
					$pdo = Conexao::connect();
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':id_produto',$id_produto);
					$stmt->execute();
					
				}catch (PDOException $e) {
						echo 'Error: <b>  na tabela produto = ' . $sql . '</b> <br /><br />' . $e->getMessage();
				}
		    }

		    public function listarTodos(){

	        try{
	            $produtos=array();
	            $pdo = Conexao::connect();
	            $consulta = $pdo->query("SELECT p.id_produto,p.preco,p.descricao,p.codigo,c.descricao_categoria,u.descricao_unidade 
				FROM produto p 
				INNER JOIN categoria_produto c ON p.id_categoria_produto = c.id_categoria_produto
				INNER JOIN unidade u ON u.id_unidade = p.id_unidade
				WHERE oculto=false");
	            $x=0;
	            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
	                $produtos[$x]=array('id_produto'=>$linha['id_produto'],'preco'=>$linha['preco'],'descricao'=>$linha['descricao'],'codigo'=>$linha['codigo'],'descricao_categoria'=>$linha['descricao_categoria'],'descricao_unidade'=>$linha['descricao_unidade']);
	                $x++;
	            }
	            } catch (PDOExeption $e){
	                echo 'Error:' . $e->getMessage;
	            }
	            return json_encode($produtos);
	        }

	        //Consultar um utilizando o ID
	        public function listarId($id_produto){
	        	try{
	        		$pdo = Conexao::connect();
	        		$sql = "SELECT p.id_produto,p.preco,p.descricao,p.codigo,p.id_categoria_produto, c.descricao_categoria, p.id_unidade, u.descricao_unidade FROM produto p 
	        		INNER JOIN categoria_produto c ON p.id_categoria_produto = c.id_categoria_produto 
	        		INNER JOIN unidade u ON p.id_unidade = u.id_unidade 
	        		WHERE p.id_produto = :id_produto";
	        		$stmt = $pdo->prepare($sql);
	        		$stmt->bindParam(':id_produto',$id_produto);

	        		$stmt->execute();
	        		$produtos = array();
	        		while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
	        			$produtos[]=array('id_produto'=>$linha['id_produto'], 'preco'=>$linha['preco'], 'descricao'=>$linha['descricao'], 'codigo'=>$linha['codigo'], 'id_categoria_produto'=>$linha['id_categoria_produto'], 'descricao_categoria'=>$linha['descricao_categoria'], 'id_unidade'=>$linha['id_unidade'], 'descricao_unidade'=>$linha['descricao_unidade']);
	        		}
	        	} catch(PDOExeption $e){
            		echo 'Erro: ' .  $e->getMessage();
        		}
        		return json_encode($produtos);	
	        }

	        public function listarporCodigo($codigo)
	        {
		        $codigo = "%" . $codigo . "%";
		        try{
		            $pdo = Conexao::connect();
		            $sql = "SELECT p.preco,p.descricao,p.codigo,c.descricao_categoria,u.descricao_unidade FROM produto p INNER JOIN categoria_produto c ON p.id_categoria_produto = i.id_categoria_produto
		            	INNER JOIN unidade u ON u.id_unidade = p.id_unidade WHERE p.codigo LIKE :codigo";
		            $consulta = $pdo->prepare($sql);
		            $consulta->execute(array(
		                ':codigo' => $codigo
		            ));
		            $produtos = Array();
		            while ($linha = $consulta-fetch(PDO::FETCH_ASSOC)) {
		                $produto = new Produto($preco,$descricao,$codigo);
		                $produtos[] = $produto;
		            }
		        }catch (PDOExeption $e){
		            echo 'Error: ' .  $e->getMessage();
		        }
		        return $produtos;
		    }
		    public function listarporNome($descricao)
	        {
		        $descricao = "%" . $descricao . "%";
		        try{
		            $pdo = Conexao::connect();
		            $sql = "SELECT p.preco,p.descricao,p.codigo,c.descricao_categoria,u.descricao_unidade FROM produto p INNER JOIN categoria_produto c ON p.id_categoria_produto = i.id_categoria_produto
		            	INNER JOIN unidade u ON u.id_unidade = p.id_unidade WHERE p.descricao LIKE :descricao";
		            $consulta = $pdo->prepare($sql);
		            $consulta->execute(array(
		                ':descricao' => $descricao
		            ));
		            $produtos = Array();
		            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		                $produto = new Produto($preco,$descricao,$codigo);
		                $produtos[] = $produto;
		            }
		        }catch (PDOExeption $e){
		            echo 'Error: ' .  $e->getMessage();
		        }
		        return $produtos;
			}

		    public function listarDescricao(){
	        try{
	            $produtos=array();
	            $x = array();
	            $pdo = Conexao::connect();
	            $consulta = $pdo->query("SELECT id_produto, descricao, codigo, preco FROM produto");
	            $x=0;
	            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
					$produtos[$x]=array('id_produto'=>$linha['id_produto'],'descricao'=>$linha['descricao'],'preco'=>$linha['preco'], 'codigo'=> $linha['codigo']);
	                $x++;
	            }
	            } catch (PDOExeption $e){
	                echo 'Error:' . $e->getMessage();
	            }
				return json_encode($produtos);
	            }

	        public function listarUm($id)
       		{
             try {
                $pdo = Conexao::connect();
                $sql = "SELECT id_produto, descricao, codigo, preco FROM produto where id_produto = :id_produto";
                $consulta = $pdo->prepare($sql);
                $consulta->execute(array(
                ':id_produto' => $id,
            ));
            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $produto = new Produto($linha['descricao'],$linha['codigo'],$linha['preco']);
                $produto->setId_produto($linha['id_produto']);
            }
            } catch (PDOException $e) {
                throw $e;
            }
            return $produto;
        }

        public function alterarProduto($produto){
        	try {
                $pdo = Conexao::connect();

                $sql = 'UPDATE produto  set id_categoria_produto=:id_categoria_produto, id_unidade=:id_unidade, descricao=:descricao, codigo=:codigo, preco=:preco WHERE id_produto=:id_produto';
                $sql = str_replace("'", "\'", $sql);            
                
                $stmt = $pdo->prepare($sql);

                
                $id_categoria_produto = $produto->get_categoria_produto()->getId_categoria_produto();
                $id_unidade=$produto->get_unidade()->getId_unidade();
                $descricao=$produto->getDescricao();
                $codigo=$produto->getCodigo();
                $preco=$produto->getPreco();
                $id_produto = $produto->getId_produto();

                $stmt->bindParam(':id_categoria_produto',$id_categoria_produto);
                $stmt->bindParam(':id_unidade',$id_unidade);            
                $stmt->bindParam(':descricao',$descricao);
                $stmt->bindParam(':codigo',$codigo);
                $stmt->bindParam(':preco',$preco);
                $stmt->bindParam(':id_produto',$id_produto);

                $stmt->execute();
            }catch (PDOExeption $e) {
                echo 'Error: <b>  na tabela produto = ' . $sql . '</b> <br /><br />' . $e->getMessage();
            }
    }

}

?>