<?php

error_reporting(0);
ini_set(“display_errors”, 0 );

require_once '../../classes/Atendido.php';
require_once '../../dao/AtendidoDAO.php';
require_once '../../classes/Documento.php';
require_once '../../dao/DocumentoDAO.php';
require_once 'DocumentoControle.php';
include_once '../../classes/Cache.php';

require_once ROOT."/controle/AtendidoControle.php";
require_once ROOT."/controle/FuncionarioControle.php";
$listaAtendidos = new AtendidoControle();
$listaAtendidos->listarTodos2();

class AtendidoControle 
{
	public function formatoDataYMD($data)
    	{
        	$data_arr = explode("/", $data);
        
        	$datac = $data_arr[2] . '-' . $data_arr[1] . '-' . $data_arr[0];
        
               return $datac;
    	}
   public function verificar(){
        extract($_REQUEST);
        session_start();
        if((!isset($nome)) || (empty($nome))){
            $msg = "Nome do Atendido não informado. Por favor, informe um nome!";
            header('Location: ../html/Cadastro_Atendido.php?msg='.$msg);
        }
        if((!isset($sobrenome)) || (empty($sobrenome))){
            $msg = "Sobrenome do Atendido não informado. Por favor, informe um sobrenome!";
            header('Location: ../html/Cadastro_Atendido.php?msg='.$msg);
        }
        if((!isset($sexo)) || (empty($sexo))){
            $msg .= "Sexo do Atendido não informado. Por favor, informe um sexo!";
            header('Location: ../html/Cadastro_Atendido.php?msg='.$msg);
        }
        if((!isset($nascimento)) || (empty($nascimento))){
            $msg .= "Data de nascimento do Atendido não informado. Por favor, informe uma data de nascimento!";
            header('Location: ../html/Cadastro_Atendido.php?msg='.$msg);
        }
        if(isset($naoPossuiCpf))
        {
            $Atendidos = $_SESSION['Atendidos2'];
            $j=0;
            for($i=0; $i<count($Atendidos); $i++)
            {
                if($nome==$Atendidos[$i]['nome'])
                {
                    $j++;
                }
            }
            if($j==0)
            {
                $numeroCPF = $nome."ni";
            }
            else
            {
                $numeroCPF = $nome.$j."ni";
            }
        }
        elseif((!isset($numeroCPF)) || (empty($numeroCPF))){
            $msg .= "CPF do Atendido não informado. Por favor, informe um CPF!";
            header('Location: ../html/Cadastro_Atendido.php?msg='.$msg);
        }
            $telefone='';
            $senha='null';
            $numeroCPF=str_replace(".", '', $numeroCPF);
            $numeroCPF=str_replace("-", "", $numeroCPF);
            $Atendido = new Atendido($numeroCPF,$nome,$sobrenome,$sexo,$nascimento,$telefone,);
           
            return $Atendido;
        }
    
    public function listarTodos(){
        extract($_REQUEST);
        $AtendidoDAO= new AtendidoDAO();
        $Atendidos = $AtendidoDAO->listarTodos();
        session_start();
        $_SESSION['Atendidos']=$Atendidos;
        header('Location: '.$nextPage);
    }

    public function listarTodos2(){
        extract($_REQUEST);
        $AtendidoDAO= new AtendidoDAO();
        $Atendidos = $AtendidoDAO->listarTodos2();
        if (session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        $_SESSION['Atendidos2']=$Atendidos;
    }

    public function listarUm()
    {
        extract($_REQUEST);
        $cache = new Cache();
        $infAtendido = $cache->read($id);
        if (!$infAtendido) {
            try {
                $AtendidoDAO=new AtendidoDAO();
                $infAtendido=$AtendidoDAO->listar($id);
                session_start();
                $_SESSION['Atendido']=$infAtendido;
                $cache->save($id, $infAtendido, '15 seconds');
                header('Location:'.$nextPage);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        else{
            header('Location:'.$nextPage);
        }
        
    }

    public function listarCpf(){
        extract($_REQUEST);
        $AtendidosDAO = new AtendidoDAO();
        $Atendidoscpf = $AtendidosDAO->listarCPF();
        $_SESSION['cpf_Atendido']=$Atendidoscpf;
    }

    public function comprimir($documParaCompressao){
			$documento_zip = gzcompress($documParaCompressao);
			return $documento_zip;
    }
        
    public function incluir(){
        $Atendido = $this->verificar();
        $intDAO = new AtendidoDAO();
        $docDAO = new DocumentoDAO();
        try{
            $idPessoa=$intDAO->incluir($Atendido);
            $_SESSION['msg']="Atendido cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro Atendido";
            $_SESSION['link']="../html/Cadastro_Atendido.php";
            header("Location: ../html/sucesso.php");
        } catch (PDOException $e){
            $msg= "Não foi possível registrar o Atendido <form> <input type='button' value='Voltar' onClick='history.go(-1)'> </form>"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function alterar()
    {
        extract($_REQUEST);
        $Atendido=$this->verificar();
        $Atendido->setidatendido($idatendido);
        $AtendidoDAO=new AtendidoDAO();
        try {
            $AtendidoDAO->alterar($Atendido);
            header("Location: ../html/Profile_Atendido.php?id=".$idatendido);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function excluir()
    {
        extract($_REQUEST);
        $AtendidoDAO=new AtendidoDAO();
        try { 
            $AtendidoDAO->excluir($id);
            header("Location:../controle/control.php?metodo=listarTodos&nomeClasse=AtendidoControle&nextPage=../html/Informacao_Atendido.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
