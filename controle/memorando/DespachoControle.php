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
require_once ROOT."/classes/memorando/Despacho.php";
require_once ROOT."/dao/memorando/DespachoDAO.php";
require_once ROOT."/dao/memorando/MemorandoDAO.php";
require_once ROOT."/controle/memorando/MemorandoControle.php";

class DespachoControle
{
	//Listar despachos
	public function listarTodos()
	{
		extract($_REQUEST);
		$despachoDAO = new DespachoDAO();
		$despachos = $despachoDAO->listarTodos($id_memorando);
		$_SESSION['despacho']=$despachos;

		$MemorandoDAO = new MemorandoDAO();
		$dadosMemorando = $MemorandoDAO->listarTodosId($id_memorando);

		if($dadosMemorando[0]['id_status_memorando'] == 3)
		{
			$memorando = new Memorando('','',$dadosMemorando[0]['id_status_memorando'],'','');
       		$memorando->setId_memorando($id_memorando);
        	$memorando->setId_status_memorando(2);
			$MemorandoDAO2 = new MemorandoDAO();
			$id_status_memorando = 2;
			$MemorandoDAO2->alterarIdStatusMemorando($memorando);
		}
	}

	//Incluir despachos  
	public function incluir()
	{
		extract($_REQUEST);
		$despacho = $this->verificarDespacho();
		$despachoDAO = new DespachoDAO();
		try
		{
			$lastId = $despachoDAO->incluir($despacho);
			$anexoss = $_FILES["anexo"];
			$anexo2 = $_FILES["anexo"]["tmp_name"][0];
    		if(isset($anexo2) && !empty($anexo2))
    		{
				require_once ROOT."/controle/memorando/AnexoControle.php";
    			$arquivo = new AnexoControle();
    			$arquivo->incluir($anexoss, $lastId);
    		}
			header("Location: ".WWW."html/memorando/listar_memorandos_ativos.php");
		}
		catch(PDOException $e)
		{
			$msg= "Não foi possível criar o despacho"."<br>".$e->getMessage();
            echo $msg;
		}
	}

	//Verificar despachos
	public function verificarDespacho()
	{
		session_start();
		$cpf_usuario = $_SESSION["usuario"];
		extract($_REQUEST);
		if(!isset($texto) || (empty($texto)))
		{
			$msg = "Texto do despacho não informado. Por favor informe um texto";
		}

		$pessoa = new UsuarioDAO();
    	$id_pessoa = $pessoa->obterUsuario($cpf_usuario);
    	$id_pessoa = $id_pessoa['0']['id_pessoa'];
    	$despacho = new Despacho($texto);
    	$despacho->setId_remetente($id_pessoa);
    	$despacho->setData();
    	$despacho->setId_destinatario($destinatario);
    	$despacho->setId_memorando($id_memorando);
    	return $despacho;
	}
}
?>