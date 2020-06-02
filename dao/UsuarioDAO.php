<?php

class UsuarioDAO
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
}
?>