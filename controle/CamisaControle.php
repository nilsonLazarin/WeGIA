<?php
include_once '../classes/Camisa.php';
include_once '../dao/CamisaDAO.php';
class CamisaControle
{
    public function verificar(){
        extract($_REQUEST);
        
        if((!isset($tamanhos)) || (empty($tamanhos))){
            $msg .= "Descricao da camisa nÃ£o informada. Por favor, informe uma descricao!";
            header('Location: ../html/camisa.html?msg='.$msg);
        }else{
            $camisa = new Camisa($tamanhos);
        }
        return $camisa;
    }
    public function listarTodos(){
        extract($_REQUEST);
        $camisaDAO= new CamisaDAO();
        $camisas = $camisaDAO->listarTodos();
        session_start();
        $_SESSION['camisa']=$camisas;
        header('Location: '.$nextPage);
    }
    public function incluir(){
        $camisa = $this->verificar();
        $camisaDAO = new CamisaDAO();
        try{
            $camisaDAO->incluir($camisa);
            session_start();
            $_SESSION['msg']="Camisa cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro camisa";
            $_SESSION['link']="../html/adicionar_camisa.php";
            header("Location: ../html/adicionar_camisa.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o camisa"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir(){
        extract($_REQUEST);
        try {
            $camisaDAO=new CamisaDAO();
            $camisaDAO->excluir($id_camisa);
            header('Location:../html/listar_almox.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
    
}
    