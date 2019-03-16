<?php
include_once '../classes/Almoxarifado.php';
include_once '../dao/AlmoxarifadoDAO.php';
class AlmoxarifadoControle
{
    public function verificar(){
        extract($_REQUEST);
        
        if((!isset($descricao_almoxarifado)) || (empty($descricao_almoxarifado))){
            $msg .= "Descricao da Almoxarifado nÃ£o informada. Por favor, informe uma descricao!";
            header('Location: ../html/almoxarifado.html?msg='.$msg);
        }else{
            $almoxarifado = new Almoxarifado($descricao_almoxarifado);
        }
        return $almoxarifado;
    }
    public function listarTodos(){
        extract($_REQUEST);
        $almoxarifadoDAO= new AlmoxarifadoDAO();
        $almoxarifados = $almoxarifadoDAO->listarTodos();
        session_start();
        $_SESSION['almoxarifado']=$almoxarifados;
        header('Location: '.$nextPage);
    }
    public function incluir(){
        $almoxarifado = $this->verificar();
        $almoxarifadoDAO = new AlmoxarifadoDAO();
        try{
            $almoxarifadoDAO->incluir($almoxarifado);
            session_start();
            $_SESSION['msg']="Almoxarifado cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro almoxarifado";
            $_SESSION['link']="../html/adicionar_almoxarifado.php";
            header("Location: ../html/adicionar_almoxarifado.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o almoxarifado"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir(){
        extract($_REQUEST);
        try {
            $almoxarifadoDAO=new AlmoxarifadoDAO();
            $almoxarifadoDAO->excluir($id_almoxarifado);
            header('Location:../html/listar_almox.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
    
}
    