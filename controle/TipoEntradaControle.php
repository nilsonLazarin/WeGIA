<?php
include_once '../classes/TipoEntrada.php';
include_once '../dao/TipoEntradaDAO.php';
class TipoEntradaControle
{
    public function verificar(){
        extract($_REQUEST);
        
        if((!isset($descricao)) || (empty($descricao))){
            $msg .= "Descricao do tipo de entrada nÃ£o informada. Por favor, informe uma descricao!";
            header('Location: ../html/tipoentrada.html?msg='.$msg);
        }else{
        	$tipoentrada = new TipoEntrada($descricao);
        }
        return $tipoentrada;
    }
    
    public function listarTodos(){
        extract($_REQUEST);
        $tipoentradaDAO= new TipoEntradaDAO();
        $tipoentradas = $tipoentradaDAO->listarTodos();
        session_start();
        $_SESSION['tipo_entrada']=$tipoentradas;
        header('Location:' .$nextPage);
    }
    
    public function incluir(){
        $tipoentrada = $this->verificar();
        $tipoentradaDAO = new TipoEntradaDAO();
        try{
            $tipoentradaDAO->incluir($tipoentrada);
            session_start();
            $_SESSION['msg']="TipoEntrada cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro TipoEntrada";
            $_SESSION['link']="../html/adicionar_tipoEntrada.php";
            header("Location: ../html/adicionar_tipoEntrada.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o tipo"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    
    public function excluir(){
        extract($_REQUEST);
        try {
            $tipoentradaDAO=new TipoEntradaDAO();
            $tipoentradaDAO->excluir($id_tipo);
            header('Location:../html/listar_tipoEntrada.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
}