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

require_once ROOT."/dao/memorando/MemorandoDAO.php";
require_once ROOT."/classes/memorando/Memorando.php";
require_once ROOT."/dao/memorando/UsuarioDAO.php";

class MemorandoControle
{
    //Listar memorandos ativos (Caixa de entrada)
	public function listarTodos()
	{
		extract($_REQUEST);
		$memorandoDAO = new MemorandoDAO();
		$memorandos = $memorandoDAO->listarTodos();
		$_SESSION['memorando']=$memorandos;
	}

    //LIstar memorando pelo Id
    public function listarTodosId($id_memorando)
    {
        extract($_REQUEST);
        $memorandoDAO = new MemorandoDAO();
        $memorandos = $memorandoDAO->listarTodosId($id_memorando);
        $_SESSION['memorandoId'] = $memorandos;
    }

    //LIstar memorandos inativos
    public function listarTodosInativos()
    {
        extract($_REQUEST);
        $memorandoDAO = new MemorandoDAO();
        $memorandos = $memorandoDAO->listarTodosInativos();
        $_SESSION['memorandoInativo'] = $memorandos;
    }

    //Criar memorando
    public function incluir()
    {
        $memorando = $this->verificarMemorando();
        $memorandoDAO = new MemorandoDAO();
        
        try
        {
            $lastId = $memorandoDAO->incluir($memorando);
            //$_SESSION['msg']="Memorando criado com sucesso";
            header("Location: ".WWW."html/memorando/insere_despacho.php?id_memorando=$lastId");

        } 
        catch (PDOException $e){
            $msg= "Não foi possível criar o memorando"."<br>".$e->getMessage();
            echo $msg;
        }
    }

    //Verifica memorando
    public function verificarMemorando()
    {
    	session_start();
    	$cpf_usuario = $_SESSION["usuario"];
    	extract($_REQUEST);
    	if((!isset($assunto)) || (empty($assunto)))
    	{
    		$msg = "Assunto do memorando não informado. Por favor, informe um assunto!";
            //header('Location: ../html/listar_memorandos_ativos.html?msg='.$msg);
    	}
    	$pessoa = new UsuarioDAO();
    	$id_pessoa = $pessoa->obterUsuario($cpf_usuario);
    	$id_pessoa = $id_pessoa['0']['id_pessoa'];
    	$memorando = new Memorando($assunto);
    	$memorando->setId_pessoa($id_pessoa);
    	$memorando->setData();
    	$memorando->setId_status_memorando(1);

    	return $memorando;
    }

    //Alterar status do memorando
    public function alterarIdStatusMemorando()
    {
        extract($_REQUEST);
        $memorando = new Memorando('','',$id_status_memorando,'','');
        $memorando->setId_memorando($id_memorando);
        $memorando->setId_status_memorando($id_status_memorando);
        $memorandoDAO=new MemorandoDAO();
        try 
        {
            $memorandoDAO->alterarIdStatusMemorando($memorando);
            header("Location: ".WWW."html/memorando/listar_memorandos_ativos.php");
        } 
        catch (PDOException $e) 
        {
            echo $e->getMessage();
        } 
    }
}
?>