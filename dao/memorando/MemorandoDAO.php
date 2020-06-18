<?php

$config_path = "config.php";
if(file_exists($config_path)){
    require_once($config_path);
}else{
    while(true){
        $config_path = "../" . $config_path;
        if(file_exists($config_path)) break;
    }
    require_once($config_path);
}

require_once ROOT."/dao/Conexao.php";
require_once ROOT."/classes/memorando/Memorando.php";
require_once ROOT."/dao/memorando/UsuarioDAO.php";

class MemorandoDAO
{
	//Listar memorandos ativos (Caixa de entrada)
	public function listarTodos()
	{
		try
		{
			$Memorandos = array();
			$pdo = Conexao::connect();
			$cpf_usuario = $_SESSION["usuario"];
			$usuario=new UsuarioDAO;
			$id_usuario=$usuario->obterUsuario($cpf_usuario);
			$id_usuario=$id_usuario['0']['id_pessoa'];
			$consulta = $pdo->query("SELECT d.id_memorando, d.id_destinatario, m.titulo, d.data, d.id_remetente, m.id_status_memorando, m.id_pessoa, d.id_destinatario FROM despacho d INNER JOIN memorando m ON(d.id_memorando=m.id_memorando) WHERE (d.id_despacho IN (SELECT MAX(id_despacho) FROM despacho GROUP BY id_memorando)) AND m.id_status_memorando!='6' AND d.id_destinatario='$id_usuario' ORDER BY m.data DESC");
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

    //LIstar memorando pelo Id
	public function listarTodosId($id_memorando)
	{
		try
		{
			$Memorando = array();
			$pdo = Conexao::connect();
			$cpf_usuario = $_SESSION["usuario"];
			$usuario=new UsuarioDAO;
			$id_usuario=$usuario->obterUsuario($cpf_usuario);
			$id_usuario=$id_usuario['0']['id_pessoa'];
			$consulta = $pdo->query("SELECT titulo, id_status_memorando, id_pessoa, id_memorando FROM memorando WHERE id_memorando='$id_memorando'");
			$x = 0;

			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
			{
				$Memorando[$x]=array('id_memorando'=>$linha['id_memorando'], 'id_pessoa'=>$linha['id_pessoa'], 'id_status_memorando'=>$linha['id_status_memorando'], 'titulo'=>$linha['titulo']);
				$x++;
			}
		}

		catch(PDOExeption $e)
		{
			echo 'Error:' . $e->getMessage;
		}

		return $Memorando;
	}


	//LIstar memorandos inativos
	public function listarTodosInativos()
	{
		try
		{
			$Memorandos = array();
			$cpf_usuario = $_SESSION["usuario"];
			$usuario = new UsuarioDAO;
			$id_usuario=$usuario->obterUsuario($cpf_usuario);
			$id_usuario=$id_usuario['0']['id_pessoa'];
			$pdo = Conexao::connect();
			$consulta = $pdo->query("SELECT DISTINCT m.id_memorando, m.titulo FROM memorando m JOIN despacho d ON(d.id_memorando=m.id_memorando) WHERE (d.id_destinatario=$id_usuario OR d.id_remetente=$id_usuario)");
			$x = 0;

			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
			{
				$Memorandos[$x]=array('id_memorando'=>$linha['id_memorando'], 'titulo'=>$linha['titulo']);
				$x++;
			}
		}

		catch(PDOExeption $e)
		{
			echo 'Error:' . $e->getMessage;
		}

		return json_encode($Memorandos);
	}

	//Criar memorando
	public function incluir($memorando)
	{
		try
		{
			$sql = "CALL insmemorando(:id_pessoa, :id_status_memorando, :titulo, :data)";
			$sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $id_pessoa = $memorando->getId_pessoa();
            $id_status_memorando = $memorando->getId_status_memorando();
            $titulo = $memorando->getTitulo();
            $data = $memorando->getData();
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_pessoa',$id_pessoa);
            $stmt->bindParam(':id_status_memorando',$id_status_memorando);
            $stmt->bindParam(':titulo',$titulo);
            $stmt->bindParam(':data',$data);
            $stmt->execute();

            $consulta=$pdo->query("SELECT MAX(id_memorando) FROM memorando");
			$x=0;

			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
			{
				$id[$x]=array('id'=>$linha['MAX(id_memorando)']);
				$x++;
			}
			$lastId = $id[0]['id'];
		}
		catch(PDOException $e)
		{
			echo 'Error: <b>  na tabela memorando = ' . $sql . '</b> <br /><br />' . $e->getMessage();
		}

		return $lastId;
	}

	//Alterar status do memorando
	public function alterarIdStatusMemorando($memorando)
	{
		try
		{
			$sql = "update memorando set id_status_memorando=:id_status_memorando where id_memorando=:id_memorando";
			$sql = str_replace("'", "\'", $sql);
			$pdo = Conexao::connect();
			$stmt = $pdo->prepare($sql);
			$id_status_memorando = $memorando->getId_status_memorando();
			$id_memorando = $memorando->getId_memorando();
			$stmt->bindParam(':id_status_memorando', $id_status_memorando);
			$stmt->bindParam(':id_memorando', $id_memorando);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			echo 'Error: <b>  na tabela memorando = ' . $sql . '</b> <br /><br />' . $e->getMessage();
		}
	}

	//Buscar último despacho de um memorando
	public function buscarUltimoDespacho($id_memorando)
	{
		try
		{
			$pdo = Conexao::connect();
			$consulta = $pdo->query("SELECT id_destinatario FROM despacho WHERE id_despacho IN (SELECT MAX(id_despacho) FROM despacho WHERE id_memorando='$id_memorando')");
			$x = 0;

			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
			{
				$Despacho[$x]=array('id_destinatario'=>$linha['id_destinatario']);
				$x++;
			}
		}

		catch(PDOExeption $e)
		{
			echo 'Error:' . $e->getMessage;
		}

		return json_encode($Despacho);
	}
}
?>