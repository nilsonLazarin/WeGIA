<?php

require_once '../classes/Cargo.php';
require_once '../dao/CargoDAO.php';

class CargoControle {
    public function incluir() {
    
        // Determina se os dados foram enviados via JSON
        if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
            // Recebe o JSON da requisição
            $json = file_get_contents('php://input');
            // Decodifica o JSON
            $data = json_decode($json, true);

            $cargoDescricao = trim(filter_var($data['cargo'], FILTER_SANITIZE_STRING));
        } else {
            // Recebe os dados do formulário normalmente
            $cargoDescricao = trim(filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING));
        }

        try {
            $cargo = new Cargo((string)($cargoDescricao));
        } catch (InvalidArgumentException $e) {
            echo 'Erro ao adicionar cargo: ' . $e->getMessage();
            return;
        }

        if ($cargo) {
            $cargoDAO = new CargoDAO();
            $cargoDAO->incluir($cargo);
        }
    }

    public function listarTodos() {
        $cargosArray = [];

        $cargoDAO = new CargoDAO();
        $cargos = $cargoDAO->listarTodos();

        foreach ($cargos as $cargo) {
            $cargosArray[] = ['id_cargo' => $cargo->getId_cargo(), 'cargo' => $cargo->getCargo()];
        }

        $cargosJSON = json_encode($cargosArray);
        echo $cargosJSON;
    }
}
