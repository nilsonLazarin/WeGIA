<?php

require_once 'Conexao.php';

class AvisoNotificacaoDAO
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexao::connect();
    }

    public function cadastrar(AvisoNotificacao $avisoNotificacao)
    {
        $sql = 'INSERT INTO aviso_notificacao (id_aviso, id_funcionario, status) VALUES(:idAviso, :idFuncionario, 1)';

        try {
            $this->pdo->beginTransaction();

            if ($this->loopCadastro($avisoNotificacao, $sql)) {
                $this->pdo->commit();
            } else {
                $this->pdo->rollBack();
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    public function loopCadastro(AvisoNotificacao $avisoNotificacao, $sql)
    {
        $funcionarios = $this->pdo->query('SELECT f.id_funcionario FROM funcionario f JOIN cargo c ON(f.id_cargo=c.id_cargo) WHERE c.cargo="Enfermeiro(a)" OR c.cargo="Téc. Enfermagem"')->fetchAll(PDO::FETCH_ASSOC);

        foreach ($funcionarios as $funcionario) {
            $stmt = $this->pdo->prepare($sql);

            $idAviso = $avisoNotificacao->getIdAviso();
            $idFuncionario = $funcionario['id_funcionario'];
            $stmt->bindParam(':idAviso', $idAviso);
            $stmt->bindParam(':idFuncionario', $idFuncionario);

            $stmt->execute();
        }

        return true;
    }

    public function buscarRecentes($idPessoa){
        
    }
}
