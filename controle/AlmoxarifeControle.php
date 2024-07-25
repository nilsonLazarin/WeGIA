<?php
    require_once '../dao/AlmoxarifeDAO.php';

    class AlmoxarifeControle {
        public function listarTodos(){
            $nextPage = trim($_REQUEST['nextPage']);

            if(!filter_var($nextPage, FILTER_VALIDATE_URL)){
                http_response_code(400);
                exit('Erro, a URL informada para a próxima página não é válida.');
            }

            $almoxarifeDAO = new almoxarifeDAO();
            $almoxarifes = $almoxarifeDAO->listarTodos();
            session_start();
            $_SESSION['almoxarife']=$almoxarifes;
            header('Location: '.$nextPage);
        }

        public function excluir(){
            $nextPage = trim($_REQUEST['nextPage']);
            $id_almoxarife = trim($_REQUEST['id_almoxarife']);

            if(!filter_var($nextPage, FILTER_VALIDATE_URL)){
                http_response_code(400);
                exit('Erro, a URL informada para a próxima página não é válida.');
            }

            if(!$id_almoxarife || !is_numeric($id_almoxarife) || $id_almoxarife < 1){
                http_response_code(400);
                exit('O id de um almoxarife deve ser um inteiro maior ou igual a 1.');
            }
            
            $almoxarifeDAO = new almoxarifeDAO();
            $almoxarifeDAO->excluir($id_almoxarife);
            header('Location: '.$nextPage);
        }
    }
?>