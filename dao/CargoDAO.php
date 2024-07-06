<?php
require_once '../classes/Cargo.php';
require_once 'Conexao.php';
require_once '../Functions/funcoes.php';

class CargoDAO
{

    public function incluir($cargo)
    {
        try {
            $pdo = Conexao::connect();

            $sql = 'INSERT cargo(cargo) VALUES(:cargo)';
            $sql = str_replace("'", "\'", $sql);

            $stmt = $pdo->prepare($sql);

            $cargo = $cargo->getCargo();

            $stmt->bindParam(':cargo', $cargo);

            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela cargo = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
    public function listarUm($id_cargo)
    {
        try {
            $pdo = Conexao::connect();
            $sql = "SELECT id_cargo, cargo  FROM cargo WHERE id_cargo = :id_cargo";
            $consulta = $pdo->prepare($sql);
            $consulta->execute(array(
                'id_cargo' => $id_cargo,
            ));
            try {
                while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $cargo = new Cargo($linha['cargo']);
                    $cargo->setId_cargo(intval($linha['id_cargo']));
                }
            } catch (InvalidArgumentException $e) {
                exit('Ocorreu um erro ao tentar listar o cargo solicitado: ' . $e->getMessage());
            }
        } catch (PDOException $e) {
            throw $e;
        }
        return $cargo;
    }
    public function excluir($id_cargo)
    {
        try {
            $pdo = Conexao::connect();
            $sql = 'DELETE FROM cargo WHERE id_cargo = :id_cargo';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_cargo', $id_cargo);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela cargo = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
    public function listarTodos()
    {

        try {
            $cargos = array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT id_cargo, cargo FROM cargo");
            $x = 0;
            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $cargos[$x] = array('id_cargo' => $linha['id_cargo'], 'cargo' => $linha['cargo']);
                $x++;
            }
        } catch (PDOException $e) {
            echo 'Error:' . $e->getMessage();
        }
        return json_encode($cargos);
    }
}
