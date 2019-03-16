<?php
include_once '../classes/Isaida.php';
include_once '../dao/IsaidaDAO.php';

class IsaidaControle
{
    public function listarId(){
        extract($_REQUEST);
        try{
            $isaidaDAO = new IsaidaDAO();
            $isaida = $isaidaDAO->listarId($id_saida);
            session_start();
            $_SESSION['isaida'] = $isaida;
            header('Location: ' . $nextPage);
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
}