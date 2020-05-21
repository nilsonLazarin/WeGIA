<?php

require_once "../classes/Memorando.php";
require_once "Conexao.php";
require_once "../Functions/funcoes.php";

class MemorandoDAO
{
	public function obterUsuario($usuario)
	{
		try
		{
			$Usuario=array();
			$pdo = Conexao::connect();
			$consulta = $pdo->query("SELECT id_pessoa FROM pessoa WHERE cpf = '$usuario'");
			$x=0;
			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
			{
				$Usuario[$x]=array('id_pessoa'=>$linha['id_pessoa']);
				$x++;
			}
		}
		catch(PDOExeption $e)
		{
			echo 'Error:' . $e->getMessage;
		}
		return $Usuario;
	}

	public function listarTodos()
	{
		try
		{
			$Memorandos = array();
			$cpf_usuario = $_SESSION["usuario"];
			$usuario=new MemorandoDAO;
			$id_usuario=$usuario->obterUsuario($cpf_usuario);
			$id_usuario=$id_usuario['0']['id_pessoa'];
			$pdo = Conexao::connect();
			$consulta = $pdo->query("SELECT d.id_memorando, d.id_destinatario, m.titulo, d.data, d.id_remetente, m.id_status_memorando, m.id_pessoa, d.id_destinatario FROM despacho d INNER JOIN memorando m ON(d.id_memorando=m.id_memorando) WHERE (d.id_despacho IN (SELECT MAX(id_despacho) FROM despacho GROUP BY id_memorando)) AND m.id_status_memorando!='8' AND d.id_destinatario='$id_usuario' ORDER BY m.data DESC");
			$x = 0;

			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
			{
				$Memorandos[$x]=array('id_memorando'=>$linha['id_memorando'], 'id_pessoa'=>$linha['id_pessoa'], 'id_status_memorando'=>$linha['id_status_memorando'], 'titulo'=>$linha['titulo'], 'data'=>$linha['data'], 'id_remetente'=>$linha['id_remetente'], 'id_destinatario'=>$linha['id_destinatario']);
				$x++;
			}
		}

		catch(PDOExeption $e)
		{
			echo 'Error:' . $e->getMessage;
		}

		return json_encode($Memorandos);
	}

	public function incluir($memorando)
	{
		try
		{
			$sql = "CALL insmemorando(:id_pessoa, :id_status_memorando, :titulo, :data)";
			$sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $id_pessoa=$memorando->getId_pessoa();
            $id_status_memorando=$memorando->getId_status_memorando();
            $titulo=$memorando->getTitulo();
            $data=$memorando->getData();
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_pessoa',$id_pessoa);
            $stmt->bindParam(':id_status_memorando',$id_status_memorando);
            $stmt->bindParam(':titulo',$titulo);
            $stmt->bindParam(':data',$data);
            $stmt->execute();
		}
		catch(PDOException $e)
		{
			echo 'Error: <b>  na tabela memorando = ' . $sql . '</b> <br /><br />' . $e->getMessage();
		}
	}
}
?>