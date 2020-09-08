<?php
    require_once '../dao/AlmoxarifeDAO.php';

    class AlmoxarifeControle {
        public function listarTodos(){
            extract($_REQUEST);
            $almoxarifeDAO = new almoxarifeDAO();
            $almoxarifes = $almoxarifeDAO->listarTodos();
            session_start();
            $_SESSION['almoxarife']=$almoxarifes;
            header('Location: '.$nextPage);
        }

        public function excluir(){
            extract($_REQUEST);
            $almoxarifeDAO = new almoxarifeDAO();
            $almoxarifeDAO->excluir($id_almoxarife);
            header('Location: '.$nextPage);
        }
    }
?>