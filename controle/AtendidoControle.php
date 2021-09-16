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
require_once '../classes/Atendido.php';
require_once '../dao/AtendidoDAO.php';
require_once '../classes/Documento.php';
require_once '../dao/DocumentoDAO.php';
require_once 'DocumentoControle.php';
include_once '../classes/Cache.php';

<<<<<<< HEAD

=======
include_once ROOT."/classes/conexao.php";
>>>>>>> 687aa7e82995d9563d25836ef15fa48d283231ff
require_once ROOT."/controle/AtendidoControle.php";
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
            if((!isset($cpf)) || (empty($cpf))){
                $msg .= "cpf do atendido não informado. Por favor, informe o cpf!";
                header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
            }
<<<<<<< HEAD
            if((!isset($nome)) || (empty($nome))){
                $msg .= "Nome do atendido não informado. Por favor, informe o nome!";
                header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg); 
            }
            if((!isset($sobrenome)) || (empty($sobrenome))){
                $msg .= "Sobrenome do atendido não informada. Por favor, informe o Sobrenome!";
                header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
            }
            if((!isset($sexo)) || (empty($sexo))){
                $msg .= "Sexo do atendido não informado. Por favor, informe o sexo!";
                header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
            }
            if((!isset($dataNascimento)) || (empty($dataNascimento))){
                $msg .= "Nascimento do atendido não informado. Por favor, informe a data!";
                header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
            }
            if((!isset($registroGeral)) || (empty($registroGeral))){
                $registroGeral= "";
            }
            if((!isset($orgaoEmissor)) || empty(($orgaoEmissor))){
                $orgaoEmissor= "";
            }
            if((!isset($dataExpedicao)) || (empty($dataExpedicao))){
                $dataExpedicao= "";
            }
            if((!isset($nomePai)) || (empty($nomePai))){
                $nomePai = '';
            }
            if((!isset($nomeMae)) || (empty($nomeMae))){
                $nomeMae = '';
            }
            if((!isset($tipoSanguineo)) || (empty($tipoSanguineo))){
                $tipoSanguineo = '';
            }
            if((!isset($cep)) || empty(($cep))){
                $cep = '';
            }
            if((!isset($uf)) || empty(($uf))){
                $uf = '';
            }
            if((!isset($cidade)) || empty(($cidade))){
                $cidade = '';
            }
            if((!isset($estado)) || empty(($estado))){
                $estado = '';
            }
            if((!isset($logradouro)) || empty(($logradouro))){
                $logradouro = '';
            }
            if((!isset($numeroEndereco)) || empty(($numeroEndereco))){
                $numeroEndereco = '';
            }
            if((!isset($bairro)) || empty(($bairro))){
                $bairro = '';
            }
            if((!isset($rua)) || empty(($rua))){
                $rua = '';
            }
            if((!isset($numero_residencia)) || empty(($numero_residencia))){
                $numero_residencia = "";
            }
            if((!isset($complemento)) || (empty($complemento))){
                $complemento='';
            }
            if((!isset($ibge)) || (empty($ibge))){
                $ibge='';
            }
            if((!isset($telefone)) || (empty($telefone))){
                $telefone='null';
            }
            if((!isset($_SESSION['imagem'])) || (empty($_SESSION['imagem']))){
                $imagem = '';
            }else{
                $imagem = base64_encode($_SESSION['imagem']);
                unset($_SESSION['imagem']);
            }

            
            // $cpf=str_replace(".", '', $cpf);
            // $cpf=str_replace("-", "", $cpf);
            //$nascimento=str_replace("-", "", $nascimento);
=======
        }
        elseif((!isset($numeroCPF)) || (empty($numeroCPF))){
            $msg .= "CPF do interno não informado. Por favor, informe um CPF!";
            header('Location: ../html/atendido/Cadastro_Atendido.php?msg='.$msg);
        }
            $telefone='';
>>>>>>> 687aa7e82995d9563d25836ef15fa48d283231ff
            $senha='null';
            $atendido = new Atendido($cpf,$nome,$sobrenome,$sexo,$dataNascimento,$registroGeral,$orgaoEmissor,$dataExpedicao,$nomeMae,$nomePai,$tipoSanguineo,$senha,$telefone,$imagem,$cep,$estado,$cidade,$bairro,$logradouro,$numeroEndereco,$complemento,$ibge);
            $atendido->setIntTipo($intTipo);
            $atendido->setIntStatus($intStatus);
            return $atendido;
        }
        
    
    public function listarTodos(){
        extract($_REQUEST);
        $AtendidoDAO= new AtendidoDAO();
        $atendidos = $AtendidoDAO->listarTodos();
        session_start();
        $_SESSION['atendidos']=$atendidos;
        header('Location: '.$nextPage);
    }

    public function listarTodos2(){
        extract($_REQUEST);
        $AtendidoDAO= new AtendidoDAO();
        $atendidos = $AtendidoDAO->listarTodos2();
        if (session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        $_SESSION['atendidos2']=$atendidos;
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
                $_SESSION['atendido']=$infAtendido;
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
        $atendidosDAO = new AtendidoDAO();
        $atendidoscpf = $atendidosDAO->listarCPF();
        $_SESSION['cpf_atendido']=$atendidoscpf;
    }

    public function comprimir($documParaCompressao){
			$documento_zip = gzcompress($documParaCompressao);
			return $documento_zip;
    }
        
    public function incluir(){
        $atendido = $this->verificar();
        var_dump($atendido);
        $intDAO = new AtendidoDAO();
        $docDAO = new DocumentoDAO();
        try{
            $idatendido=$intDAO->incluir($atendido);
            $_SESSION['msg']="Atendido cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro atendido";
            $_SESSION['link']="../html/atendido/Cadastro_Atendido.php";
            header("Location: ../html/sucesso.php");
            // header("Location: ../dao/AtendidoDAO.php");
        } catch (PDOException $e){
            $msg= "Não foi possível registrar o atendido <form> <input type='button' value='Voltar' onClick='history.go(-1)'> </form>"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function alterar()
    {
        extract($_REQUEST);
        $atendido=$this->verificar();
        $atendido->setidatendido($idatendido);
        $AtendidoDAO=new AtendidoDAO();
        try {
<<<<<<< HEAD
            $AtendidoDAO->alterar($atendido);
            header("Location: ../html/Profile_Atendido.php?id=".$idatendido);
=======
            $internoDAO->alterar($interno);
            header("Location: ../html/atendido/Profile_Atendido.php?id=".$idInterno);
>>>>>>> 687aa7e82995d9563d25836ef15fa48d283231ff
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function excluir()
    {
        extract($_REQUEST);
        $AtendidoDAO=new AtendidoDAO();
        try {
<<<<<<< HEAD
            $AtendidoDAO->excluir($id);
            header("Location:../controle/control.php?metodo=listarTodos&nomeClasse=AtendidoControle&nextPage=../html/Informacao_Atendido.php");
=======
            $internoDAO->excluir($id);
            header("Location:../controle/control.php?metodo=listarTodos&nomeClasse=AtendidoControle&nextPage=../html/atendido/Informacao_Atendido.php");
>>>>>>> 687aa7e82995d9563d25836ef15fa48d283231ff
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
