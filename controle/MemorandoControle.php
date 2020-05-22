<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include_once "../classes/Memorando.php";
include_once "../dao/MemorandoDAO.php";

class MemorandoControle
{
	public function listarTodos()
	{
		extract($_REQUEST);
		$memorandoDAO = new MemorandoDAO();
		$memorandos = $memorandoDAO->listarTodos();
		$_SESSION['memorando']=$memorandos;
	}

    public function incluir()
    {
        $memorando = $this->verificarMemorando();
        $memorandoDAO = new MemorandoDAO();
        
        try{
            $memorandoDAO->incluir($memorando);
            //$_SESSION['msg']="Funcionario cadastrado com sucesso";
            //$_SESSION['link']="../html/cadastro_funcionario.php";
            header("Location: ../html/listar_memorandos_ativos.php");

        } catch (PDOException $e){
            $msg= "Não foi possível criar o memorando"."<br>".$e->getMessage();
            echo $msg;
        }
    }

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
    	$pessoa = new MemorandoDAO();
    	$id_pessoa = $pessoa->obterUsuario($cpf_usuario);
    	$id_pessoa = $id_pessoa['0']['id_pessoa'];
    	$memorando = new Memorando($assunto);
    	$memorando->setId_pessoa($id_pessoa);
    	$memorando->setData();
    	$memorando->setId_status_memorando(1);

    	return $memorando;
    }
}

$memorando = new MemorandoControle();
$memorando->listarTodos();
?>