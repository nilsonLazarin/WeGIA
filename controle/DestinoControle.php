<?php
include_once '../classes/Destino.php';
include_once '../dao/DestinoDAO.php';
class DestinoControle
{
    public function verificar(){
        extract($_REQUEST);
        if((!isset($nome)) || (empty($nome))){
            $msg = "Nome do destino nÃ£o informado. Por favor, informe um nome!";
            header('Location: ../html/destino.html?msg='.$msg);
        }
        if((!isset($cnpj)) || (empty($cnpj))){
            $calcado='null';
        }
        if((!isset($cpf)) || (empty($cpf))){
            $calca='null';
        }
        if((!isset($telefone)) || (empty($telefone))){
            $msg .= "Telefone do destino nÃ£o informado. Por favor, informe um telefone!";
            header('Location: ../html/destino.html?msg='.$msg);
        }
        $cpf=str_replace(".", '', $cpf);
        $cpf=str_replace("-", "", $cpf);
        $destino = new Destino($nome,$cnpj,$cpf,$telefone);
        $destino->setNome($nome);
        $destino->setCnpj($cnpj);
        $destino->setCpf($cpf);
        $destino->setTelefone($telefone);
        
        return $destino;
    }
    
    public function listarTodos(){
        extract($_REQUEST);
        $destinoDAO= new DestinoDAO();
        $destinos = $destinoDAO->listarTodos();
        session_start();
        $_SESSION['destino']=$destinos;
        header('Location: '.$nextPage);
    }
    
    public function incluir(){
        $destino = $this->verificar();
        $destinoDAO = new DestinoDAO();
        try{
            $destinoDAO->incluir($destino);
            session_start();
            $_SESSION['msg']="Destino cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro Destino";
            $_SESSION['link']="../html/cadastro_destino.php";
            header("Location: ../html/cadastro_destino.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o tipo"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir(){
        extract($_REQUEST);
        try {
            $destinoDAO=new DestinoDAO();
            $destinoDAO->excluir($id_destino);
            header('Location:../html/listar_destino.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
}