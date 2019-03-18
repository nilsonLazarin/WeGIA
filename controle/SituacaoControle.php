<?php
include_once '../classes/Situacao.php';
include_once '../dao/SituacaoDAO.php';
class SituacaoControle
{
    public function verificar(){
        extract($_REQUEST);
        
        if((!isset($situacoes)) || (empty($situacoes))){
            $msg .= "Descricao da Situacao nÃ£o informada. Por favor, informe uma descricao!";
            header('Location: ../html/situacao.html?msg='.$msg);
        }else{
            $situacao = new Situacao($situacoes);
        }
        return $situacao;
    }
    public function listarTodos(){
        extract($_REQUEST);
        $situacaoDAO= new SituacaoDAO();
        $situacaos = $situacaoDAO->listarTodos();
        session_start();
        $_SESSION['situacao']=$situacoes;
        header('Location: '.$nextPage);
    }
    public function incluir(){
        $situacao = $this->verificar();
        $situacaoDAO = new SituacaoDAO();
        try{
            $situacaoDAO->incluir($situacao);
            session_start();
            $_SESSION['msg']="Almoxarifado cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro almoxarifado";
            $_SESSION['link']="../html/adicionar_situacao.php";
            header("Location: ../html/adicionar_situacao.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o situacao"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir(){
        extract($_REQUEST);
        try {
            $situacaoDAO=new SituacaoDAO();
            $situacaoDAO->excluir($id_situacao);
            header('Location:../html/listar_calca.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
    
}
    