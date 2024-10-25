<?php 

// require "../../dao/Conexao.php";

class EnfermidadeSaude {
    private $id_CID; 
    private $extensao;
    private $exception = false;

    function __construct($id)
    {
        $id = (int) $id;
        $this->setid_CID($id);
        try {
            $pdo = Conexao::connect();
            $query = $pdo->query("SELECT id_CID, data_diagnostico, status FROM saude_enfermidades WHERE id_CID = $id;");
        } catch (PDOException $e) {
            $this->setException("Houve um erro ao consultar o documento no banco de dados: $e");
        }
    }
    
    public function getid_CID()
    {
        return $this->id_CID;
    }
     
    public function setid_CID($id_CID)
    {
        $this->id_CID = $id_CID;
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
    // o excluir enfermidade é basicamente tornar o status da tabela inativo, por isso um update //
    function delete(){
        try {
            $sql = "UPDATE saude_enfermidades SET status = 0 WHERE id_CID = ".$this->getid_CID()." ;";
            $pdo = Conexao::connect();
            
		    $stmt = $pdo->prepare($sql);
		    $stmt->execute();

            $query = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->setException("Houve um erro ao remover o documento do banco de dados: $e");
        }
    }

}
