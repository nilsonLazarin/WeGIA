<?php

require_once 'Conexao.php';
require_once '../classes/Aviso.php';

class AvisoDAO
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexao::connect();
    }

    public function cadastrar(Aviso $aviso)
    {
        $sql = 'INSERT INTO aviso(id_funcionario_aviso, id_pessoa_atendida, descricao, data) VALUES (:idFuncionario, :idPessoaAtendida, :descricao, :data);';

        $idFuncionario = $aviso->getIdFuncionario();
        $idPessoaAtendida = $aviso->getIdPessoaAtendida();
        //echo $idPessoaAtendida;
        $descricao = $aviso->getDescricao();

        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':idFuncionario', $idFuncionario);
            $stmt->bindParam(':idPessoaAtendida', $idPessoaAtendida);
            $stmt->bindParam(':descricao', $descricao);

            date_default_timezone_set('America/Sao_Paulo');
            $data = date('Y-m-d H:i:s');
            $stmt->bindParam(':data', $data);

            $stmt->execute();

            $ultimoID = $this->pdo->lastInsertId();

            //Criar posteriormente função própria para realizar pesquisa por ID
            $informacoesUltimoId = $this->procuraPorID($ultimoID);

            if ($informacoesUltimoId['id_funcionario_aviso'] == $idFuncionario && $informacoesUltimoId['id_pessoa_atendida'] == $idPessoaAtendida && $informacoesUltimoId['descricao'] == $descricao) {

                $this->pdo->commit();
                return $ultimoID;
            } else {
                $this->pdo->rollBack();
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function procuraPorID($id)
    {
        $sql = 'SELECT id_funcionario_aviso, id_pessoa_atendida, descricao FROM aviso WHERE id_aviso=:id';

        try {

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}
