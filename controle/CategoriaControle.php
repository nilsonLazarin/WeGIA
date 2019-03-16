<?php
include_once '../classes/Categoria.php';
include_once '../dao/CategoriaDAO.php';
class CategoriaControle
{
    public function verificar(){
        extract($_REQUEST);
        if((!isset($descricao_categoria)) || (empty($descricao_categoria))){
            $msg = "Descricao da Categoria não informada. Por favor, informe uma descricao!";
            header('Location: ../html/categoria.html?msg='.$msg);
        }
        else{
            $categoria = new Categoria($descricao_categoria);
        }
        return $categoria;
    }
    public function listarTodos(){
        extract($_REQUEST);
        $categoriaDAO= new CategoriaDAO();
        $categorias = $categoriaDAO->listarTodos();
        session_start();
        $_SESSION['categoria']=$categorias;
        echo $_SESSION['categoria'];
        header('Location: '.$nextPage);
    }
    
    public function incluir(){
        $categoria = $this->verificar();
        $categoriaDAO = new CategoriaDAO();
        try{
            $categoriaDAO->incluir($categoria);
            header("Location: ../html/adicionar_categoria.php");
        } catch (PDOException $e){
            $msg= "Não foi possível registrar a categoria"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir(){
    	extract($_REQUEST);
        try {
            $categoriaDAO=new CategoriaDAO();
            $categoriaDAO->excluir($id_categoria_produto);
            header('Location:../html/listar_categoria.php');
        } catch (PDOException $e) {
            $msg = "Não foi possível excluir essa categoria, pois ela já deve existir um produto cadastrado com essa categoria"."<br>".$e->getMessage();
            echo $msg;
        }
    }
}