<?php
    require_once 'Conexao.php';
    require_once '../classes/Almoxarife.php';

    class AlmoxarifeDAO {
        public function listarTodos(){
            try{
                $pdo = Conexao::connect();
                $almoxarife = $pdo->query("
                    SELECT afe.id_almoxarife, afe.id_funcionario, afe.id_almoxarifado, almox.descricao_almoxarifado, p.nome as descricao_funcionario, afe.data_registro
                    FROM almoxarife afe
                    LEFT JOIN almoxarifado almox ON almox.id_almoxarifado = afe.id_almoxarifado
                    LEFT JOIN funcionario f ON f.id_funcionario = afe.id_funcionario
                    LEFT JOIN pessoa p ON p.id_pessoa = f.id_pessoa
                    ;
                ")->fetchAll(PDO::FETCH_ASSOC);
                return json_encode($almoxarife);
            }catch (PDOException $e){
                echo 'Error:' . $e->getMessage;
            }
        }

        public function excluir($id){
            try {
                $pdo = Conexao::connect();
                $pdo->exec("DELETE FROM almoxarife WHERE id_almoxarife=$id;");
            } catch (PDOException $e) {
                echo 'Error:' . $e->getMessage;
            }
        }
    }
?>