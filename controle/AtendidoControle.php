<?php

error_reporting(0);
ini_set(“display_errors”, 0 );

require_once '../classes/Interno.php';
require_once '../dao/InternoDAO.php';
require_once '../classes/Documento.php';
require_once '../dao/DocumentoDAO.php';
require_once 'DocumentoControle.php';
include_once '../classes/Cache.php';

include_once ROOT."/classes/conexao.php";
require_once ROOT."/controle/AtendidoControle.php";
require_once ROOT."/controle/FuncionarioControle.php";
$listaInternos = new AtendidoControle();
$listaInternos->listarTodos2();

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
            $msg = "Nome do interno não informado. Por favor, informe um nome!";
            header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
        }
        if((!isset($sobrenome)) || (empty($sobrenome))){
            $msg = "Sobrenome do interno não informado. Por favor, informe um sobrenome!";
            header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
        }
        if((!isset($sexo)) || (empty($sexo))){
            $msg .= "Sexo do interno não informado. Por favor, informe um sexo!";
            header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
        }
        if((!isset($nascimento)) || (empty($nascimento))){
            $msg .= "Data de nascimento do interno não informado. Por favor, informe uma data de nascimento!";
            header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
        }
        if(isset($naoPossuiCpf))
        {
            $internos = $_SESSION['internos2'];
            $j=0;
            for($i=0; $i<count($internos); $i++)
            {
                if($nome==$internos[$i]['nome'])
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
            $msg .= "CPF do interno não informado. Por favor, informe um CPF!";
            header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
        }
            $telefone='';
            $senha='null';
            $numeroCPF=str_replace(".", '', $numeroCPF);
            $numeroCPF=str_replace("-", "", $numeroCPF);
            $interno = new Interno($numeroCPF,$nome,$sobrenome,$sexo,$nascimento,$telefone,);
           
            return $interno;
        }
    
    public function listarTodos(){
        extract($_REQUEST);
        $internoDAO= new InternoDAO();
        $internos = $internoDAO->listarTodos();
        session_start();
        $_SESSION['internos']=$internos;
        header('Location: '.$nextPage);
    }

    public function listarTodos2(){
        extract($_REQUEST);
        $internoDAO= new InternoDAO();
        $internos = $internoDAO->listarTodos2();
        if (session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        $_SESSION['internos2']=$internos;
    }

    public function listarUm()
    {
        extract($_REQUEST);
        $cache = new Cache();
        $infInterno = $cache->read($id);
        if (!$infInterno) {
            try {
                $internoDAO=new InternoDAO();
                $infInterno=$internoDAO->listar($id);
                session_start();
                $_SESSION['interno']=$infInterno;
                $cache->save($id, $infInterno, '15 seconds');
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
        $internosDAO = new InternoDAO();
        $internoscpf = $internosDAO->listarCPF();
        $_SESSION['cpf_interno']=$internoscpf;
    }

    public function comprimir($documParaCompressao){
			$documento_zip = gzcompress($documParaCompressao);
			return $documento_zip;
    }
        
    public function incluir(){
        $interno = $this->verificar();
        $intDAO = new InternoDAO();
        $docDAO = new DocumentoDAO();
        try{
            $idPessoa=$intDAO->incluir($interno);
            $_SESSION['msg']="Interno cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro interno";
            $_SESSION['link']="../html/atendido/Cadastro_Atendido.php";
            header("Location: ../html/sucesso.php");
        } catch (PDOException $e){
            $msg= "Não foi possível registrar o interno <form> <input type='button' value='Voltar' onClick='history.go(-1)'> </form>"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function alterar()
    {
        extract($_REQUEST);
        $interno=$this->verificar();
        $interno->setIdInterno($idInterno);
        $internoDAO=new InternoDAO();
        try {
            $internoDAO->alterar($interno);
            header("Location: ../html/atendido/Profile_Atendido.php?id=".$idInterno);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function excluir()
    {
        extract($_REQUEST);
        $internoDAO=new InternoDAO();
        try {
            $internoDAO->excluir($id);
            header("Location:../controle/control.php?metodo=listarTodos&nomeClasse=AtendidoControle&nextPage=../html/atendido/Informacao_Atendido.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
