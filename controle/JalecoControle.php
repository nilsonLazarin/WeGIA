<?php
include_once '../classes/Jaleco.php';
include_once '../dao/JalecoDAO.php';
class JalecoControle
{
    
    public function verificar(){
        extract($_REQUEST);
        
        if((!isset($tamanhos)) || (empty($tamanhos))){
            $msg .= "Descricao da jaleco nÃ£o informada. Por favor, informe uma descricao!";
            header('Location: ../html/jaleco.html?msg='.$msg);
        }else{
            $jaleco = new Jaleco($tamanhos);
        }
        return $jaleco;
    }
    public function listarTodos(){
        extract($_REQUEST);
        $jalecoDAO= new JalecoDAO();
        $jalecos = $jalecoDAO->listarTodos();
        session_start();
        $_SESSION['jaleco']=$jalecos;
        header('Location: '.$nextPage);
    }
    public function incluir(){
        $jaleco = $this->verificar();
        $jalecoDAO = new JalecoDAO();
        try{
            $jalecoDAO->incluir($jaleco);
            session_start();
            $_SESSION['msg']="jaleco cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro jaleco";
            $_SESSION['link']="../html/adicionar_jaleco.php";
            header("Location: ../html/adicionar_jaleco.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o jaleco"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir(){
        extract($_REQUEST);
        try {
            $jalecoDAO=new JalecoDAO();
            $jalecoDAO->excluir($id_jaleco);
            header('Location:../html/listar_almox.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
    
}
    