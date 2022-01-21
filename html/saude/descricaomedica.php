<?php 

// require "../../dao/Conexao.php";

class DescricaoMedicaSaude {
    private $id_atendimento; 
    private $extensao;
    private $exception = false;

    function __construct($id)
    {
        $id = (int) $id;
        $this->setid_atendimento($id);
        try {
            $pdo = Conexao::connect();
            $query = $pdo->query("SELECT id_atendimento, descricao FROM saude_atendimento WHERE id_atendimento = $id;");
            // $query = strip_tags($sql, '<p>');

        } catch (PDOException $e) {
            $this->setException("Houve um erro ao consultar o documento no banco de dados: $e");
        }
    }
    
    public function getid_atendimento()
    {
        return $this->id_atendimento;
    }
     
    public function setid_atendimento($id_atendimento)
    {
        $this->id_atendimento = $id_atendimento;
        return $this;
    }
    
    public function getExtensao()
    {
        return $this->extensao;
    }

    public function setExtensao($extensao)
    {
        $this->extensao = $extensao;

        return $this;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setException($exception)
    {
        $this->exception = $exception;

        return $this;
    }

    // Metodos
    
    function delete(){
        try {
            $pdo = Conexao::connect();
            $query = $pdo->query("DELETE FROM saude_atendimento WHERE id_atendimento = ".$this->getid_atendimento()." ;");
            $query = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->setException("Houve um erro ao remover o documento do banco de dados: $e");
        }
    }

}
