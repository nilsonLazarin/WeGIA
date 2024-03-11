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

        $sql = "SELECT a.descricao, a.data, p.nome as atendido_nome, p.sobrenome as atendido_sobrenome, pe.nome as funcionario_nome, pe.sobrenome as funcionario_sobrenome
        FROM pessoa as p 
        JOIN aviso as a ON (p.id_pessoa=a.id_pessoa_atendida) 
        JOIN aviso_notificacao as an ON (a.id_aviso=an.id_aviso) 
        JOIN funcionario as f ON (an.id_funcionario=f.id_funcionario) 
        JOIN funcionario as fu ON (a.id_funcionario_aviso=fu.id_funcionario) 
        JOIN pessoa as pe ON(fu.id_pessoa=pe.id_pessoa) 
        WHERE f.id_pessoa=$idPessoa AND an.status=1
        ORDER BY a.data DESC";

        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $avisos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $avisos;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    public function contarRecentes($idPessoa){
        $sql = "SELECT count(an.id_aviso_notificacao) as qtd_notificacoes FROM aviso_notificacao as an JOIN funcionario as f ON (an.id_funcionario=f.id_funcionario) WHERE f.id_pessoa=$idPessoa AND an.status=1";

        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $quantidade = $stmt->fetch();
            return $quantidade['qtd_notificacoes'];
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
}