<?php 

// require "../../dao/Conexao.php";

class MedicacaoSaude {
    private $id_medicacao; 
    private $extensao;
    private $exception = false;

    function __construct($id)
    {
        $id = (int) $id;
        $this->setid_medicacao($id);
        try {
            $pdo = Conexao::connect();
            $query = $pdo->query("SELECT * FROM saude_medicacao WHERE id_medicacao = $id;");            

        } catch (PDOException $e) {
            $this->setException("Houve um erro ao consultar o documento no banco de dados: $e");
        }
    }
    
    public function getid_medicacao()
    {
        return $this->id_medicacao;
    }
     
    public function setid_medicacao($id_medicacao)
    {
        $this->id_medicacao = $id_medicacao;
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
            $query = $pdo->query("DELETE FROM saude_medicacao WHERE id_medicacao = ".$this->getid_medicacao()." ;");
            $query = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->setException("Houve um erro ao remover o documento do banco de dados: $e");
        }
    }

}
