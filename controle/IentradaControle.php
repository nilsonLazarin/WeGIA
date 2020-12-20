<?php
include_once '../classes/Ientrada.php';
include_once '../dao/IentradaDAO.php';

class IentradaControle
{
    public function listarId(){
        extract($_REQUEST);
        try{
            $ientradaDAO = new IentradaDAO();
            $ientrada = $ientradaDAO->listarId($id_entrada);
            session_start();
            $_SESSION['ientrada'] = $ientrada;
            header('Location: ' . $nextPage);
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
}