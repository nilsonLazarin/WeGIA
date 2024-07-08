<?php

require_once '../classes/Cargo.php';
require_once '../dao/CargoDAO.php';

class CargoControle{
    public function incluir(){
        $cargoDescricao = trim($_POST["cargo"]);

        try{
            $cargo = new Cargo($cargoDescricao);    
        }catch(InvalidArgumentException $e){
            echo 'Erro ao adicionar cargo: ' .$e->getMessage();
        }

        if($cargo){
            $cargoDAO = new CargoDAO();
            $cargoDAO->incluir($cargo);
        }
    }

    public function listarTodos(){
        $cargosArray = [];

        $cargoDAO = new CargoDAO();
        $cargos = $cargoDAO->listarTodos();

        foreach($cargos as $cargo){
            $cargosArray []= ['id_cargo' => $cargo->getId_cargo(), 'cargo' => $cargo->getCargo()];
        }

        $cargosJSON = json_encode($cargosArray);
        echo $cargosJSON;
    }
}