<?php
include_once '../classes/Calca.php';
include_once '../dao/CalcaDAO.php';
class CalcaControle
{
    public function verificar(){
        extract($_REQUEST);
        
        if((!isset($tamanhos)) || (empty($tamanhos))){
            $msg .= "Descricao da calca nÃ£o informada. Por favor, informe uma descricao!";
            header('Location: ../html/calca.html?msg='.$msg);
        }else{
            $calca = new calca($tamanhos);
        }
        return $calca;
    }
    public function listarTodos(){
        extract($_REQUEST);
        $calcaDAO= new CalcaDAO();
        $calcas = $calcaDAO->listarTodos();
        session_start();
        $_SESSION['calca']=$tamanhos;
        header('Location: '.$nextPage);
    }
    public function incluir(){
        $calca = $this->verificar();
        $calcaDAO = new CalcaDAO();
        try{
            $calcaDAO->incluir($calca);
            session_start();
            $_SESSION['msg']="Almoxarifado cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro almoxarifado";
            $_SESSION['link']="../html/adicionar_calca.php";
            header("Location: ../html/adicionar_calca.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o calca"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir(){
        extract($_REQUEST);
        try {
            $calcaDAO=new CalcaDAO();
            $calcaDAO->excluir($id_calca);
            header('Location:../html/listar_calca.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
    
}
    