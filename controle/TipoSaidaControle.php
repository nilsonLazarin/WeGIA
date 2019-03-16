<?php
include_once '../classes/TipoSaida.php';
include_once '../dao/TipoSaidaDAO.php';
class TipoSaidaControle
{
    public function verificar(){
        extract($_REQUEST);
        
        if((!isset($descricao)) || (empty($descricao))){
            $msg .= "Descricao do tipo de saida nÃ£o informada. Por favor, informe uma descricao!";
            header('Location: ../html/tiposaida.html?msg='.$msg);
        }else{
        	$tiposaida = new TipoSaida($descricao);
        }
        return $tiposaida;
    }
    
    public function listarTodos(){
        extract($_REQUEST);
        $tiposaidaDAO= new TipoSaidaDAO();
        $tiposaida = $tiposaidaDAO->listarTodos();
        session_start();
        $_SESSION['tipo_saida']=$tiposaida;
        header('Location: ' .$nextPage);
    }
    
    public function incluir(){
        $tiposaida = $this->verificar();
        $tiposaidaDAO = new TipoSaidaDAO();
        try{
            $tiposaidaDAO->incluir($tiposaida);
            session_start();
            $_SESSION['msg']="TipoSaida cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro TipoSaida";
            $_SESSION['link']="../html/adicionar_tipoSaida.php";
            header("Location: ../html/cadastro_saida.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o tipo"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    
    public function excluir(){
        extract($_REQUEST);
        try {
            $tiposaidaDAO=new TipoSaidaDAO();
            $tiposaidaDAO->excluir($id_tipo);
            header('Location:../html/listar_tipoSaida.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
}