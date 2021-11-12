<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

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
require_once ROOT."/classes/Atendido_ocorrencia.php";
require_once ROOT."/dao/Atendido_ocorrenciaDAO.php";
require_once ROOT."/controle/Atendido_ocorrenciaControle.php";

class Atendido_ocorrenciaControle
{
	//Listar despachos
	public function listarTodos(){
        extract($_REQUEST);
        $atendido_ocorrenciaDAO= new atendido_ocorrenciaDAO();
        $ocorrencias = $atendido_ocorrenciaDAO->listarTodos();
        session_start();
        $_SESSION['ocorrencia']=$ocorrencias;
        header('Location: '.$nextPage);
    }

		// $MemorandoDAO = new MemorandoDAO();
		// $dadosMemorando = $MemorandoDAO->listarTodosId($id_memorando);

		// $ultimoDespacho =  new MemorandoControle;
		// $ultimoDespacho->buscarUltimoDespacho($id_memorando);

		// if(!empty($_SESSION['ultimo_despacho']))
		// {
		// if($dadosMemorando[0]['id_status_memorando'] == 3 AND $_SESSION['ultimo_despacho'][0]['id_destinatarioo']==$_SESSION['id_pessoa'])
		// {
		// 	$memorando = new Memorando('','',$dadosMemorando[0]['id_status_memorando'],'','');
       	// 	$memorando->setId_memorando($id_memorando);
        // 	$memorando->setId_status_memorando(2);
		// 	$MemorandoDAO2 = new MemorandoDAO();
		// 	$id_status_memorando = 2;
		// 	$MemorandoDAO2->alterarIdStatusMemorando($memorando);
		// }
		//}
	

	//Listar Despachos com anexo
	public function listarTodosComAnexo()
	{
		extract($_REQUEST);
		$despachoComAnexoDAO = new DespachoDAO();
		$despachosComAnexo = $despachoComAnexoDAO->listarTodosComAnexo($id_memorando);
		$_SESSION['despachoComAnexo'] = $despachosComAnexo;
	}

	//Incluir despachos  
	public function incluir()
	{
		extract($_REQUEST);
		$ocorrencia = $this->verificar();
		$ocorrenciaDAO = new Atendido_ocorrenciaDAO();
		try
		{
			$lastId = $ocorrenciaDAO->incluir($ocorrencia);
			$anexoss = $_FILES["anexo"];
			$anexo2 = $_FILES["anexo"]["tmp_name"][0];
			var_dump($anexo2);
    		// if(isset($anexo2) && !empty($anexo2))
    		// {
			// 	// require_once ROOT."/controle/AnexoControle.php";
    		// 	$arquivo = new AnexoControle();
    		// 	$arquivo->incluir($anexoss, $lastId);
    		// }
    		$msg = "success";
			$sccd = "Ocorrencia enviada com sucesso";
			header("Location: ".WWW."html/atendido/listar_ocorrencias_ativas.php?msg=".$msg."&sccd=".$sccd);
		}
		catch(PDOException $e)
		{
			$msg= "Não foi possível criar o despacho"."<br>".$e->getMessage();
            echo $msg;
		}
	}

	public function verificar(){
		extract($_REQUEST);
		// se não estiver definida ou vazia//
		if((!isset($descricao)) || (empty($descricao))){
			$msg .= "Descricao do atendido não informado. Por favor, informe a descricao!";
			header('Location: ../html/atendido/cadastro_ocorrencia.php?msg='.$msg); 
		}
		if((!isset($atendido_idatendido)) || (empty($atendido_idatendido))){
		 	$atendido_idatendido=""; 
		}
		if((!isset($id_funcionario)) || (empty($id_funcionario))){
			$id_funcionario=""; 
	    }

	    if((!isset($id_tipos_ocorrencia)) || (empty($id_tipos_ocorrencia))){
			$id_tipos_ocorrencia="";
		}
		// if((!isset($idatendido_ocorrencias)) || (empty($idatendido_ocorrencias))){
		// 	$idatendido_ocorrencias="";
		// }
		if((!isset($data)) || (empty($data))){
			$msg .= "Data da ocorrencia não informada. Por favor, informe a data!";
			header('Location: ../html/atendido/cadastro_ocorrencia.php?msg='.$msg); 
	    }
		// if((!isset($nome)) || (empty($nome))){
		// 	$msg .= "Data da ocorrencia não informada. Por favor, informe a data!";
		// 	header('Location: ../html/atendido/cadastro_ocorrencia.php?msg='.$msg); 
	    // }

	$ocorrencia = new Ocorrencia($descricao);  
	$ocorrencia->setAtendido_idatendido($atendido_idatendido);
	// $ocorrencia->setNome($nome);  
	$ocorrencia->setFuncionario_idfuncionario($id_funcionario); 
	$ocorrencia->setId_tipos_ocorrencia($id_tipos_ocorrencia); 
	// $ocorrencia->setIdatendido_ocorrencias($idatendido_ocorrencias);
	$ocorrencia->setData($data);  
	return $ocorrencia;
	}
	//Verificar despachos
	// public function verificarDespacho()
	// {
	// 	session_start();
	// 	$cpf_usuario = $_SESSION["usuario"];
	// 	extract($_REQUEST);
	// 	if(!isset($descricao) || (empty($descricao)))
	// 	{
	// 		$msg = "Ocorrência não informada. Por favor informe um texto.";
	// 	}
	// 	$pessoa = new Atendido_ocorrenciaDAO();
    // 	// $id_pessoa = $pessoa->obterUsuario($cpf_usuario);
    // 	// $id_pessoa = $id_pessoa['0']['id_pessoa'];
    // 	$ocorrencia = new Ocorrencia($descricao);
    // 	$ocorrencia->setId_pessoa($id_pessoa);
    // 	$ocorrencia->setData();
    // 	$ocorrencia->setId_tipos_ocorrencia($id_tipos_ocorrencia);
    // 	$ocorrencia->setIdatendido_ocorrencias($idatendido_ocorrencias);
    // 	return $ocorrencia;
	// }
}
?>