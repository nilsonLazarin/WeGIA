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

$SaudePetDAO_path = "dao/pet/SaudePetDAO.php";
if(file_exists($SaudePetDAO_path)){
    require_once($SaudePetDAO_path);
}else{
    while(true){
        $SaudePetDAO_path = "../" . $SaudePetDAO_path;
        if(file_exists($SaudePetDAO_path)) break;
    }
    require_once($SaudePetDAO_path);
}

$SaudePet_path = "classes/pet/SaudePet.php";
if(file_exists($SaudePet_path)){
    require_once($SaudePet_path);
}else{
    while(true){
        $SaudePet_path = "../" . $SaudePet_path;
        if(file_exists($SaudePet_path)) break;
    }
    require_once($SaudePet_path);
}

include_once ROOT."/dao/Conexao.php";

class controleSaudePet
{
    public function verificar(){
            extract($_REQUEST);
            
            if((!isset($texto)) || (empty($texto))){
                $msg = "Descrição não informada!";
            header("Location: ../../html/pet/cadastro_ficha_medica_pet.php?msg=".$msg);
            return;
            }
            if((!isset($nome)) || (empty($nome))){
                $msg = "Nome não informado!";
                header("Location: ../../html/pet/cadastro_ficha_medica_pet.php?msg=".$msg);
                return;
            }
            if((!isset($castrado)) || (empty($castrado))){
                $msg = "Estado da castração não informado!";
                header("Location: ../../html/pet/cadastro_ficha_medica_pet.php?msg=".$msg);
                return;
            }
            /*if((!isset($_SESSION['imagem'])) || (empty($_SESSION['imagem']))){
                $imagem = '';
            }else{
                $imagem = base64_encode($_SESSION['imagem']);
                unset($_SESSION['imagem']);
            }*/
        $senha='null';
        $saudePet = new SaudePet($nome,$texto, $castrado);

        $saudePet->setNome($nome);
        $saudePet->setTexto($texto);
        $saudePet->setCastrado($castrado);
        return $saudePet;
    }

    
    public function listarTodos(){
        extract($_REQUEST);
        $SaudePetDAO = new SaudePetDAO();
        $pets = $SaudePetDAO->listarTodos();
        session_start();
        $_SESSION['saudepet']=$pets;
        header('Location: '.$nextPage);
    }

/*
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
                $_SESSION['id_fichamedica']=$infSaude;Saude
                $cache->save($id, $infSaude, '1 seconds');
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
*/

    public function incluir(){
        $pet = $this->verificar();
        $intDAO = new SaudePetDAO();
        try{
            $idSaudePet=$intDAO->incluir($pet);
            $_SESSION['msg']="Ficha médica cadastrada com sucesso!";
            $_SESSION['proxima']="Cadastrar outra ficha.";
            $_SESSION['link']="../html/saude/cadastro_ficha_medica_pet.php";
        } catch (PDOException $e){
            $msg= "Não foi possível registrar o paciente <form> <input type='button' value='Voltar' onClick='history.go(-1)'> </form>"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    /*
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
        
    }*/
   
}