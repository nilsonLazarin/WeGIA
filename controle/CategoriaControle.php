<?php
include_once '../classes/Categoria.php';
include_once '../dao/CategoriaDAO.php';
class CategoriaControle
{
    public function verificar(){
        //extract($_REQUEST);
        $descricao_categoria = trim($_REQUEST['descricao_categoria']);
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
        //extract($_REQUEST);
        $nextPage = trim($_REQUEST['nextPage']);

        if(!filter_var($nextPage, FILTER_VALIDATE_URL)){
            http_response_code(400);
            exit('Erro, a URL informada para a próxima página não é válida.');
        }

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
            echo "Não foi possível registrar a categoria";
        }
    }
    public function editar(){
        //extract($_REQUEST);
        $id_categoria_produto = trim($_REQUEST['id_categoria_produto']);
        $descricao_categoria = trim($_REQUEST['descricao_categoria']);

        if(!$id_categoria_produto || !is_numeric($id_categoria_produto) || $id_categoria_produto < 1){
            http_response_code(400);
            exit('O id de uma categoria deve ser um inteiro maior ou igual a 1.');
        }

        if(!$descricao_categoria || empty($descricao_categoria)){
            http_response_code(400);
            exit('A descrição de uma categoria não pode ser vazia.');
        }

        $categoriaDAO = new CategoriaDAO();
        try{
            $categoriaDAO->editar($id_categoria_produto, $descricao_categoria);
            header("Location: ../html/listar_categoria.php");
        } catch (PDOException $e){
            echo "Não foi possível editar a categoria";
        }
    }
    public function excluir(){
    	//extract($_REQUEST);
        $id_categoria_produto = trim($_REQUEST['id_categoria_produto']);

        if(!$id_categoria_produto || !is_numeric($id_categoria_produto) || $id_categoria_produto < 1){
            http_response_code(400);
            exit('O id de uma categoria deve ser um inteiro maior ou igual a 1.');
        }

        try {
            $categoriaDAO=new CategoriaDAO();
            $categoriaDAO->excluir($id_categoria_produto);
            header('Location:../html/listar_categoria.php');
        } catch (PDOException $e) {
            echo "Não foi possível excluir essa categoria, pois já deve existir um produto cadastrado com essa categoria";
        }
    }
}