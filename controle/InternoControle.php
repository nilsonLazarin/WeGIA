<?php
require_once '../classes/Interno.php';
require_once '../dao/InternoDAO.php';
require_once '../classes/Documento.php';
require_once '../dao/DocumentoDAO.php';
require_once 'DocumentoControle.php';
include_once '../classes/Cache.php';

require_once ROOT."/controle/InternoControle.php";
require_once ROOT."/controle/FuncionarioControle.php";
$listaInternos = new InternoControle();
$listaInternos->listarTodos2();

class InternoControle 
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
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if((!isset($sobrenome)) || (empty($sobrenome))){
            $msg = "Sobrenome do interno não informado. Por favor, informe um sobrenome!";
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if((!isset($sexo)) || (empty($sexo))){
            $msg .= "Sexo do interno não informado. Por favor, informe um sexo!";
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if((!isset($nascimento)) || (empty($nascimento))){
            $msg .= "Data de nascimento do interno não informado. Por favor, informe uma data de nascimento!";
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if((!isset($pai)) || (empty($pai))){
            $msg .= "Nome do pai do interno não informado. Por favor, informe um nome!";
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if((!isset($nomeMae)) || (empty($nomeMae))){
            $msg .= "Nome da mae do interno não informado. Por favor, informe um nome!";
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if((!isset($sangue)) || (empty($sangue))){
            $msg .= "Tipo sanguineo do interno não informado. Por favor, informe um tipo sanguineo!";
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if(isset($naoPossuiRegistroGeral)){
            $rg = "NãoInformado";
            $orgaoEmissor="Não informado";
            $dataExpedicao = null;
        }
        elseif((!isset($rg)) || (empty($rg))){
            $msg .= "Registro geral do interno não informado. Por favor, informe um registro geral!";
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if((!isset($orgaoEmissor)) || (empty($orgaoEmissor))){
            $msg .= "Orgao emissor do interno não informado. Por favor, informe um orgão emissor!";
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if((!isset($dataExpedicao)) || (empty($dataExpedicao))){
            $msg .= "Data de expedição do rg do interno não informado. Por favor, informe um data de expedição!";
            header('Location: ../html/interno.php?msg='.$msg);
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
            header('Location: ../html/interno.php?msg='.$msg);
        }
        if((!isset($certidao)) || (empty($certidao))){
            $certidao="Não possui";
        }
        if((!isset($curatela)) || (empty($curatela))){
            $curatela="Não possui";
        }
        if((!isset($tituloEleitor)) || (empty($tituloEleitor))){
            $tituloEleitor="Não possui";
        }
        if((!isset($certidaoCasamento)) || (empty($certidaoCasamento))){
            $certidaoCasamento="Não possui";
        }
        if((!isset($ctps)) || (empty($ctps))){
            $ctps="Não possui";
        }
        if((!isset($inss)) || (empty($inss))){
            $inss="Não possui";
        }
        if((!isset($loas)) || (empty($loas))){
            $loas="Não possui";
        }
        if((!isset($bpc)) || (empty($bpc))){
            $bpc="Não possui";
        }
        if((!isset($funrural)) || (empty($funrural))){
            $funrural="Não possui";
        }
        if((!isset($saf)) || (empty($saf))){
            $saf="Não possui";
        }
        if((!isset($sus)) || (empty($sus))){
            $sus="Não possui";
        }
        if((!isset($observacao)) || (empty($observacao))){
            $observacao="Descrição não informada";
        }
        if((!isset($telefone1)) || (empty($telefone1))){
            $telefone1='Não informado';
        }
        if((!isset($telefone2)) || (empty($telefone2))){
            $telefone2='Não informado';
        }
        if((!isset($telefone3)) || (empty($telefone3))){
            $telefone3='Não informado';
        }
        if((!isset($nomeContato)) || (empty($nomeContato))){
            $nomeContato='Não informado';
        }  
            $telefone='(22) 2522-5130';
            $senha='null';

            $existeimagem = new InternoControle;
            $existeimagem->listarUM();
            $internoo = json_decode($_SESSION['interno']);
            $internoo1 = (array)$internoo[0];
            if(isset($_SESSION['imagem']))
            {
            	$imagem=base64_encode($_SESSION['imagem']);
                unset($_SESSION['imagem']);
            }
            else{
                if($internoo1['imagem']!="")
                {
                    $imagem = $internoo1['imagem'];
                }
                else
                {
            	$imagem="";
                }
            }
            $cep='28625-520';
            $estado="RJ";
            $cidade='Nova Friburgo';
            $bairro='Centro';
            $logradouro='Rua Souza Cardoso';
            $numeroEndereco='403';
            $complemento='Mora no LAJE';
            $ibge="3303401";
            $numeroCPF=str_replace(".", '', $numeroCPF);
            $numeroCPF=str_replace("-", "", $numeroCPF);
            $interno = new Interno($numeroCPF,$nome,$sobrenome,$sexo,$nascimento,$rg,$orgaoEmissor,$dataExpedicao,$nomeMae,$pai,$sangue,$senha,$telefone,$imagem,$cep,$estado,$cidade,$bairro,$logradouro,$numeroEndereco,$complemento,$ibge);
            $interno->setNomeContatoUrgente($nomeContato);
            $interno->setTelefoneContatoUrgente1($telefone1);
            $interno->setTelefoneContatoUrgente2($telefone2);
            $interno->setTelefoneContatoUrgente3($telefone3);
            $interno->setCertidaoNascimento($certidao);
            $interno->setCuratela($curatela);
            $interno->setInss($inss);
            $interno->setLoas($loas);
            $interno->setBpc($bpc);
            $interno->setFunrural($funrural);
            $interno->setSaf($saf);
            $interno->setSus($sus);
            $interno->setCertidaoCasamento($certidaoCasamento);
            $interno->setCtps($ctps);
            $interno->setTitulo($tituloEleitor);
            $interno->setObservacao($observacao);
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
        session_start();
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
    
    public function incluir(){
        $interno = $this->verificar();
        $intDAO = new InternoDAO();
        $docDAO = new DocumentoDAO();
        try{
            $idPessoa=$intDAO->incluir($interno);
            if(!empty($_FILES['imgRg']['tmp_name']) && $rg!="Não informado")
				{
					$imagem=base64_encode(file_get_contents($_FILES['imgRg']['tmp_name']));
					$extensao=pathinfo($_FILES['imgRg']['name'],PATHINFO_EXTENSION);
					$descricao="Registro Geral";
					$documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
					$docDAO->incluir($documento);
				}
			if(!empty($_FILES['imgCpf']['tmp_name']))
				{
					$imagem=base64_encode(file_get_contents($_FILES['imgCpf']['tmp_name']));
					$extensao=pathinfo($_FILES['imgCpf']['name'],PATHINFO_EXTENSION);
					$descricao="CPF";
					$documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
					$docDAO->incluir($documento);
				}
			if(!empty($_FILES['imgCtps']['tmp_name']))
				{
					$imagem=base64_encode(file_get_contents($_FILES['imgCtps']['tmp_name']));
					$extensao=pathinfo($_FILES['imgCtps']['name'],PATHINFO_EXTENSION);
					$descricao="CTPS";
					$documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
					$docDAO->incluir($documento);
				}
            if(!empty($_FILES['imgCertidaoNascimento']['tmp_name']))
            {
                    $imagem=base64_encode(file_get_contents($_FILES['imgCertidaoNascimento']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgCertidaoNascimento']['name'],PATHINFO_EXTENSION);
                    $descricao="Certidão de Nascimento";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
            }
                if(!empty($_FILES['imgCuratela']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgCuratela']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgCuratela']['name'],PATHINFO_EXTENSION);
                    $descricao="Curatela";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
                if(!empty($_FILES['imgTituloEleitor']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgTituloEleitor']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgTituloEleitor']['name'],PATHINFO_EXTENSION);
                    $descricao="Título de Eleitor";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
                if(!empty($_FILES['imgCertidaoCasamento']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgCertidaoCasamento']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgCertidaoCasamento']['name'],PATHINFO_EXTENSION);
                    $descricao="Certidão de Casamento";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
                if(!empty($_FILES['imgCtps']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgCtps']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgCtps']['name'],PATHINFO_EXTENSION);
                    $descricao="CTPS";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
                if(!empty($_FILES['imgInss']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgInss']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgInss']['name'],PATHINFO_EXTENSION);
                    $descricao="INSS";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
                if(!empty($_FILES['imgLoas']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgLoas']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgLoas']['name'],PATHINFO_EXTENSION);
                    $descricao="LOAS";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
                if(!empty($_FILES['imgBpc']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgBpc']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgBpc']['name'],PATHINFO_EXTENSION);
                    $descricao="BPC";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
                if(!empty($_FILES['imgFunrural']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgFunrural']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgFunrural']['name'],PATHINFO_EXTENSION);
                    $descricao="Funrural";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
                if(!empty($_FILES['imgSaf']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgSaf']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgSaf']['name'],PATHINFO_EXTENSION);
                    $descricao="SAF";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
                if(!empty($_FILES['imgSus']['tmp_name']))
                {
                    $imagem=base64_encode(file_get_contents($_FILES['imgSus']['tmp_name']));
                    $extensao=pathinfo($_FILES['imgSus']['name'],PATHINFO_EXTENSION);
                    $descricao="SUS";
                    $documento=new Documento($idPessoa,$imagem,$extensao,$descricao);
                    $docDAO->incluir($documento);
                }
            $_SESSION['msg']="Interno cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro interno";
            $_SESSION['link']="../html/cadastro_interno.php";
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
            //header("Location: ../html/profile_interno.php?id=".$idInterno);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function alterarImagem()
    {
        extract($_REQUEST);
        $image = file_get_contents ($_FILES['imgperfil']['tmp_name']);
        $perfil = base64_encode($image);
        $interno = new Interno('','','','','','','','','','','','','',$perfil,'','','','','','','','');
        $interno->setIdInterno($id_interno);
        $internoDAO = new InternoDAO();
        try {
            $internoDAO->alterarImagem($interno);
            header("Location: ../html/profile_interno.php?id=".$id_interno);
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
            header("Location:../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=../html/informacao_interno.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
