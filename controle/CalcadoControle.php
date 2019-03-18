<?php
include_once '../classes/Calcado.php';
include_once '../dao/CalcadoDAO.php';
class CalcadoControle
{
    public function verificar(){
        extract($_REQUEST);
        
        if((!isset($tamanhos)) || (empty($tamanhos))){
            $msg .= "Descricao da calcado nÃ£o informada. Por favor, informe uma descricao!";
            header('Location: ../html/calcado.html?msg='.$msg);
        }else{
            $calcado = new Calcado($tamanhos);
        }
        return $calcado;
    }
    public function listarTodos(){
        extract($_REQUEST);
        $calcadoDAO= new CalcadoDAO();
        $calcados = $calcadoDAO->listarTodos();
        session_start();
        $_SESSION['calcado']=$calcados;
        header('Location: '.$nextPage);
    }
    public function incluir(){
        $calcado = $this->verificar();
        $calcadoDAO = new CalcadoDAO();
        try{
            $calcadoDAO->incluir($calcado);
            session_start();
            $_SESSION['msg']="calcado cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro calcado";
            $_SESSION['link']="../html/adicionar_calcado.php";
            header("Location: ../html/adicionar_calcado.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o calcado"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir(){
        extract($_REQUEST);
        try {
            $calcadoDAO=new CalcadoDAO();
            $calcadoDAO->excluir($id_calcado);
            header('Location:../html/listar_almox.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
    
}
    