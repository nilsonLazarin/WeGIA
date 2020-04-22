<?php


session_start();
if(!isset($_SESSION['usuario'])){
header ("Location: ../index.php");
}

$teste=$_SESSION["usuario"];

require_once "../classes/Memorando.php";
require_once "Conexao.php";
require_once "../Functions/funcoes.php";


class MemorandoDAO

{

	public function listarTodos()

	{

		try

		{

			$Memorandos = array();
			$pdo = Conexao::connect();
			$consulta = $pdo->query("SELECT pessoa.nome, despacho.texto, despacho.id_remetente, despacho.data FROM despacho JOIN pessoa WHERE id_memorando=".$teste." AND despacho.id_remetente=pessoa.id_pessoa ORDER BY despacho.data DESC");
			$x = 0;

			

			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))

			{

				$Memorandos[$x]=array('id_memorando'=>$linha['id_memorando'], 'id_pessoa'=>$linha['id_pessoa'], 'id_status_memorando'=>$linha['id_status_memorando'], 'titulo'=>$linha['titulo'], 'data'=>$linha['data']);
				$x++;

			}

		}

		catch(PDOExeption $e)

		{

			echo 'Error:' . $e->getMessage;

		}

		return json_encode($Memorandos);

	}

}

?>