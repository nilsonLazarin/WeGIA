<?php
include_once '../classes/Categoria.php';
include_once '../dao/CategoriaDAO.php';
include_once '../classes/Unidade.php';
include_once '../dao/UnidadeDAO.php';
include_once '../classes/Produto.php';
include_once '../dao/ProdutoDAO.php';

class ProdutoControle
{
    public function verificar(){
        extract($_REQUEST);
        if((!isset($descricao)) || empty(($descricao))){
            $msg .= "descricao do produto nÃ£o informado. Por favor, informe um descricao!";
            header('Location: ../html/produto.html?msg='.$msg);
        }
        if((!isset($codigo)) || empty(($codigo))){
            $msg .= "Código do produto nÃ£o informado. Por favor, informe o código!";
            header('Location: ../html/produto.html?msg='.$msg);
        }
        if((!isset($preco)) || empty(($preco))){
            $msg .= "Preço do produto nÃ£o informado. Por favor, informe um preço!";
            header('Location: ../html/produto.html?msg='.$msg);
        }else{
        $produto = new produto($descricao,$codigo,$preco);

        return $produto;
        }
    }
    public function listarTodos(){
        extract($_REQUEST);
        $produtoDAO= new produtoDAO();
        $produtos = $produtoDAO->listarTodos();
        session_start();
        $_SESSION['produtos']=$produtos;
        header('Location: '.$nextPage);
    }
    
    public function listarporCodigo($codigo)
    {
        session_start();
        $codigo = $_REQUEST['codigo'];
        try {
            $produtoDao = new ProdutoDAO();
            $produto = $produtoDao->listarUm($codigo);
            $_SESSION['produto']= $produto;
        } catch (Exception $e) {
            $msg = "Não foi possível listar o produto!";
            header('Location: caminho.php?msg='.$msg);
        }

        $catDao = new CategoriaDAO();
        $categorias = $catDao->listarTodos();
        $_SESSION['categorias']= $categorias;
        
        header('Location: '.$_REQUEST['nextPage']);
        
    }
    public function listarporNome($descricao)
    {
        session_start();
        $descricao = $_REQUEST['descricao'];
        try {
            $produtoDao = new ProdutoDAO();
            $produto = $produtoDao->listarUm($descricao);
            $_SESSION['produto']= $produto;
        } catch (Exception $e) {
            $msg = "Não foi possível listar o produto!";
            header('Location: ../html/msg.php?msg='.$msg);
        }

        $catDao = new CategoriaDAO();
        $categorias = $catDao->listarTodos();
        $_SESSION['categorias']= $categorias;
        
        header('Location: '.$_REQUEST['nextPage']);
        
    }

    public function listarDescricao(){
        $produtoDAO = new ProdutoDAO();
        $produtos = $produtoDAO->listarDescricao();
        session_start();
        $_SESSION['autocomplete']=$produtos;
        header('Location: '.$_REQUEST['nextPage']);
    }
    
    public function incluir(){
        $produto = $this->verificar();
        extract($_REQUEST);
        $produtoDAO = new ProdutoDAO();
        $catDAO = new CategoriaDAO();
        $uniDAO = new UnidadeDAO();

        $categoria = $catDAO->listarUm($id_categoria);
        $unidade = $uniDAO->listarUm($id_unidade);
        try{
            
            $produto->set_categoria_produto($categoria);
            $produto->set_unidade($unidade);
            
            $produtoDAO->incluir($produto);

            session_start();
            header("Location: ../html/cadastro_produto.php");
        } catch (PDOException $e){
            $msg= "Não foi possível registrar o funcionário"."<br>".$e->getMessage();
            echo $msg;
        }
    }
    public function excluir()
    {
        extract($_REQUEST);
        try {
            $produtoDAO = new ProdutoDAO();
            $produtoDAO->excluir($id_produto);
            header('Location:../html/listar_produto.php');
        } catch (PDOException $e) {
            echo "ERROR";
        }
    }

    public function listarId(){
        extract($_REQUEST);
        $id = $_GET['id_produto'];
        try{
            $produtoDAO = new ProdutoDAO();
            $produto = $produtoDAO->listarId($id);
            session_start();
            $_SESSION['produto'] = $produto;
            header('Location: ' . $nextPage );
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
    public function alterarProduto(){
        extract($_REQUEST);
        $produto = new Produto($descricao,$codigo,$preco);
        $produtoDAO = new ProdutoDAO();
        $catDAO = new CategoriaDAO();
        $uniDAO = new UnidadeDAO();

        $categoria = $catDAO->listarUm($id_categoria);
        $unidade = $uniDAO->listarUm($id_unidade);

        try {
            $produto->setId_produto($id_produto);
            $produto->set_categoria_produto($categoria);
            $produto->set_unidade($unidade);
            $produtoDAO->alterarProduto($produto);
            header('Location: '.$nextPage);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }
}