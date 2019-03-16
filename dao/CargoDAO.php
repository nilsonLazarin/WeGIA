<?php
require_once'../classes/Cargo.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';

class CargoDAO
{
    public function incluir($cargo)
    {
        try {
            $sql = 'INSERT into cargo (cargo) VALUES (:descricao)';
            $sql = str_replace("'", "\'", $sql);

            $pdo = Conexao::connect();
            $descricao=$cargo->getDescricao();
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':descricao', $descricao);
            
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela cargo = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function excluir($idcargo)
    {
        try {
            $sql = 'DELETE from cargo WHERE idcargo = :idcargo';
            $sql = str_replace("'", "\'", $sql);
            $acesso = new Acesso();
            
            $pdo = $acesso->conexao();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':idcargo', $idcargo);
            
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela cargos = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function alterar($idcargos, $descricao)
    {
        try {
            $sql = 'update cargo set id_cargo=:idcargos,descricao=:descricao where id_cargo= :idcargos';
            $sql = str_replace("'", "\'", $sql);
            $acesso = new Acesso();
            
            $pdo = $acesso->conexao();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':idcargos', $idcargos);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela cargos = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
}