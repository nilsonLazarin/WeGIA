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

//include_once "/dao/Conexao.php";
require_once ROOT.'/classes/Saude.php';
require_once ROOT.'/dao/SaudeDAO.php';
require_once ROOT.'/classes/Documento.php';
require_once ROOT.'/dao/DocumentoDAO.php';
require_once 'DocumentoControle.php';
include_once ROOT.'/classes/Cache.php';

include_once ROOT."/dao/Conexao.php";

class SaudeControle 


{   
    
    public function verificar(){
            extract($_REQUEST);
            
            if((!isset($texto)) || (empty($texto))){
                $msg .= "Descricao do atendido não informado. Por favor, informe a descricao!";
                header('Location: ../html/saude/cadastro_ficha_medica.php?msg='.$msg); 
            }
            if((!isset($cpf)) || (empty($cpf))){
                $cpf= "";
            }
            if((!isset($nome)) || (empty($nome))){
                $nome= "";
            }
            if((!isset($sobrenome)) || (empty($sobrenome))){
                $sobrenome= "";
            }
            if((!isset($sexo)) || (empty($sexo))){
                $sexo= "";
            }
            if((!isset($dataNascimento)) || (empty($dataNascimento))){
                $dataNascimento= "";
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
            // if((!isset($uf)) || empty(($uf))){
            //     $uf = '';
            // }
            if((!isset($cidade)) || empty(($cidade))){
                $cidade = '';
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
            if((!isset($complemento)) || (empty($complemento))){
                $complemento='';
            }
            if((!isset($ibge)) || (empty($ibge))){
                $ibge='';
            }
            if((!isset($telefone)) || (empty($telefone))){
                $telefone='null';
            }
            if((!isset($estado)) || (empty($estado))){
                $estado='null';
            }
            if((!isset($_SESSION['imagem'])) || (empty($_SESSION['imagem']))){
                $imagem = '';
            }else{
                $imagem = base64_encode($_SESSION['imagem']);
                unset($_SESSION['imagem']);
            }
        $senha='null';
        $saude = new Saude($cpf,$nome,$sobrenome,$sexo,$dataNascimento,$registroGeral,$orgaoEmissor,$dataExpedicao,$nomeMae,$nomePai,$tipoSanguineo,$senha,$telefone,$imagem,$cep,$estado,$cidade,$bairro,$logradouro,$numeroEndereco,$complemento,$ibge);
        
        // $saude->setNome($nome);
        $saude->setTexto($texto);  
        $saude->setEnfermidade($enfermidade);
        $saude->setData_diagnostico($data_diagnostico);
        $saude->setIntStatus($intStatus);
        return $saude;
    }

    // aq era atendidos
    public function listarTodos(){
        extract($_REQUEST);
        $SaudeDAO= new SaudeDAO();
        $pacientes = $SaudeDAO->listarTodos();
        session_start();
        $_SESSION['saude']=$pacientes;
        header('Location: '.$nextPage);
    }

    public function listarUm()
    {
        extract($_REQUEST);
        $cache = new Cache();
        $infSaude = $cache->read($id);
        if (!$infSaude) {
            try {
                $SaudeDAO=new SaudeDAO();
                $infSaude=$SaudeDAO->listar($id);
                session_start();
                $_SESSION['id_fichamedica']=$infSaude;
                $cache->save($id, $infSaude, '15 seconds');
                header('Location:'.$nextPage);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        else{
            header('Location:'.$nextPage);
        }
    }

    public function alterarImagem()
    {
        extract($_REQUEST);
        $imagem = file_get_contents($_FILES['imgperfil']['tmp_name']);
        $SaudeDAO = new SaudeDAO();
        try {
            $SaudeDAO->alterarImagem($id_fichamedica, $imagem);
            header("Location: ../html/saude/profile_paciente.php?id_fichamedica=".$id_fichamedica);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function incluir(){
        $saude = $this->verificar();
        $intDAO = new SaudeDAO();
        //$docDAO = new DocumentoDAO();

        try{
            $idsaude=$intDAO->incluir($saude);
            $_SESSION['msg']="Ficha médica cadastrada com sucesso!";
            $_SESSION['proxima']="Cadastrar outra ficha.";
            $_SESSION['link']="../html/saude/cadastro_ficha_medica.php";
            header("Location: ../html/saude/profile_paciente.php");
            // header("Location: ../dao/AtendidoDAO.php");
        } catch (PDOException $e){
            $msg= "Não foi possível registrar o paciente <form> <input type='button' value='Voltar' onClick='history.go(-1)'> </form>"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function alterarInfPessoal()
    {
        extract($_REQUEST);
        // $paciente = new Saude('',$nome,$sobrenome,$sexo,$nascimento,'','','','','',$tipoSanguineo,'','',$imagem,'','','','','','','','');
        $paciente = new Saude('','','','','','','','','','',$tipoSanguineo,'','','','','','','','','','','');
        $paciente->setId_pessoa($id_fichamedica);
        //echo $funcionario->getId_Funcionario();
        $SaudeDAO=new SaudeDAO();
        try {
            $SaudeDAO->alterarInfPessoal($paciente);
            header("Location: ../html/saude/profile_paciente.php?id_fichamedica=".$id_fichamedica);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }
}