<?php
include_once '../classes/Estoque.php';
include_once '../dao/EstoqueDAO.php';

class EstoqueControle
{
    public function listarTodos(){
        extract($_REQUEST);
        $estoqueDAO= new EstoqueDAO();
        $estoques = $estoqueDAO->listarTodos();
        session_start();
        $_SESSION['estoque']=$estoques;
        header('Location: '.$nextPage);
    }
    
}