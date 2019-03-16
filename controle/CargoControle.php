<?php
include_once '../classes/Cargo.php';
include_once '../dao/CargoDAO.php';
class CargoControle
{

    public function verificar(){
        extract($_REQUEST);
        if((!isset($descricao)) || (empty($descricao))){
            $msg = "Nome do cargo não informado. Por favor, informe um nome!";
            header('Location: ../html/cargo.php?msg='.$msg);
        }
        
    
        $cargo = new Cargo();
        $cargo->setDescricao($descricao);
        
        return $cargo;
    }
    public function listarTodos(){
        extract($_REQUEST);
        $cargoDAO= new CargoDAO();
        $cargos = $cargoDAO->listarTodos();
        session_start();
        $_SESSION['cargos']=$cargos;
        header('Location: '.$nextPage);
    }
    
    public function listarUm($id)
    {
        $cargoDAO = new CargoDAO();
        
    }
    
    public function incluir(){
        $cargo = $this->verificar();
        $cargoDAO = new CargoDAO();
        try{
            $cargoDAO->incluir($cargo);
            session_start();
            $_SESSION['msg']="Cargo cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro cargo";
            $_SESSION['link']="../html/cadastro_cargo.php";
            header("Location: ../html/sucesso.php");
        } catch (PDOException $e){
            $msg= "Não foi possível registrar o cargo"."<br>".$e->getMessage();
            echo $msg;
        }
    }
}