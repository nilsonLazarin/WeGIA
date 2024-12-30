<?php
include_once '../dao/QuadroHorarioDAO.php';

class QuadroHorarioControle
{
    // Tipos

    public function listarTipo(){
        extract($_REQUEST);
        (new QuadroHorarioDAO())->listarTipos();
        header("Location: $nextPage");
    }

    public function adicionarTipo(){
        extract($_REQUEST);
        session_start();
        try {
            $log = (new QuadroHorarioDAO())->adicionarTipo($tipo);;
            $_SESSION['msg'] = $log;
        } catch (PDOException $e) {
            echo("Erro ao adicionar tipo '$tipo' ao banco de dados: " . $e->getMessage());
            $_SESSION['msg'] = "Erro ao adicionar tipo: " . $e->getMessage();
            $_SESSION['flag'] = "erro";
        }
        $_SESSION['btnVoltar'] = true;
        header("Location: $nextPage");
    }

    public function removerTipo(){
        extract($_REQUEST);
        $log = (new QuadroHorarioDAO)->removerTipo($id);
        session_start();
        $_SESSION['msg'] = $log;
        header("Location: $nextPage");
    }

    // Escalas

    public function listarEscala(){
        extract($_REQUEST);
        (new QuadroHorarioDAO())->listarEscalas();
        header("Location: $nextPage");
    }

    public function adicionarEscala(){
        $escala = trim(filter_input(INPUT_POST, 'escala', FILTER_SANITIZE_STRING));
        $nextPage = trim(filter_input(INPUT_POST, 'nextPage', FILTER_SANITIZE_URL));

        if(!$escala || strlen($escala) == 0){
            http_response_code(400);
            echo json_encode(['erro' => 'A escala não pode ser vazia.']);
            exit();
        }

        session_start();
        try {
            $log = (new QuadroHorarioDAO())->adicionarEscala($escala);
            $_SESSION['msg'] = $log;
        } catch (PDOException $e) {
            echo("Erro ao adicionar escala '$escala' ao banco de dados: " . $e->getMessage());
            $_SESSION['msg'] = "Erro ao adicionar escala: " . $e->getMessage();
            $_SESSION['flag'] = "erro";
        }
        $_SESSION['btnVoltar'] = true;

        if($nextPage){
            header("Location: $nextPage");
        }
    }

    public function removerEscala(){
        extract($_REQUEST);
        $log = (new QuadroHorarioDAO)->removerEscala($id);
        session_start();
        $_SESSION['msg'] = $log;
        header("Location: $nextPage");
    }
}