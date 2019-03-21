<?php
include_once '../classes/Cargo.php';
include_once '../dao/CargoDAO.php';
class CargoControle
{
    
    public function verificar(){
        extract($_REQUEST);
        
        if((!isset($cargo)) || (empty($cargo))){
            $msg .= "Descricao da cargo nÃ£o informada. Por favor, informe uma descricao!";
            header('Location: ../html/cargo.html?msg='.$msg);
        }else{
            $cargo = new Cargo($cargo);
        }
        return $cargo;
    }
    public function listarTodos(){
        extract($_REQUEST);
        $cargoDAO= new CargoDAO();
        $cargos = $cargoDAO->listarTodos();
        session_start();
        $_SESSION['cargo']=$cargos;
        header('Location: '.$nextPage);
    }
    public function incluir(){
        $cargo = $this->verificar();
        $cargoDAO = new CargoDAO();
        try{
            $cargoDAO->incluir($cargo);
            session_start();
            $_SESSION['msg']="cargo cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro cargo";
            $_SESSION['link']="../html/cadastro_cargo.php";
            header("Location: ../html/cadastro_cargo.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o cargo"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir(){
        extract($_REQUEST);
        try {
            $cargoDAO=new cargoDAO();
            $cargoDAO->excluir($id_cargo);
            header('Location:../html/listar_almox.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }
    
}
    