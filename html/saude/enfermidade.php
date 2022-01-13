<?php 

// require "../../dao/Conexao.php";

class EnfermidadeSaude {
    private $id_CID; // aq é o numero do nome
    private $data;
    private $status;
    // private $documento;
    // private $descricao;
    private $extensao;
    private $nome;
    private $exception = false;

    // Constructor

    function __construct($id)
    {
        $id = (int) $id;
        $this->setid_Enfermidade($id);
        try {
            $pdo = Conexao::connect();
            $query = $pdo->query("SELECT descricao, data_diagnostico, status FROM saude_enfermidades se JOIN saude_tabelacid st ON se.id_CID = st.id_CID WHERE id_CID = $id ;");
            $query = $query->fetch(PDO::FETCH_ASSOC);
            // $this->setDocumento(base64_decode(gzuncompress($query["arquivo"])));
            $this->setStatus($query["intStatus"]);
            // $this->setNome($query["arquivo_nome"]);
        } catch (PDOException $e) {
            $this->setException("Houve um erro ao consultar o documento no banco de dados: $e");
        }
    }


    // Getters & Setters
    
    public function getid_CID()
    {
        return $this->id_CID;
    }

     
    public function setid_CID($id_CID)
    {
        $this->id_CID = $id_CID;

        return $this;
    }

    // public function getDocumento()
    // {
    //     return $this->documento;
    // }

    // public function setDocumento($documento)
    // {
    //     $this->documento = $documento;

    //     return $this;
    // }

    public function getException()
    {
        return $this->exception;
    }

    public function setException($exception)
    {
        $this->exception = $exception;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    // Metodos

    function delete(){
        try {
            $pdo = Conexao::connect();
            $query = $pdo->query("DELETE FROM saude_exames WHERE id_exame = ".$this->getid_exame()." ;");
            $query = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->setException("Houve um erro ao remover o documento do banco de dados: $e");
        }
    }

}
