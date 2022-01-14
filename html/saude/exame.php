<?php 

// require "../../dao/Conexao.php";

class ExameSaude {
    private $id_exame;
    private $documento;
    private $extensao;
    private $nome;
    private $exception = false;

    // Constructor

    function __construct($id)
    {
        $id = (int) $id;
        $this->setid_exame($id);
        try {
            $pdo = Conexao::connect();
            $query = $pdo->query("SELECT arquivo_extensao, arquivo_nome, arquivo FROM saude_exames WHERE id_exame = $id ;");
            $query = $query->fetch(PDO::FETCH_ASSOC);
            $this->setDocumento(base64_decode(gzuncompress($query["arquivo"])));
            $this->setExtensao($query["arquivo_extensao"]);
            $this->setNome($query["arquivo_nome"]);
        } catch (PDOException $e) {
            $this->setException("Houve um erro ao consultar o documento no banco de dados: $e");
        }
    }

    // Getters & Setters
    
    public function getid_exame()
    {
        return $this->id_exame;
    }

     
    public function setid_exame($id_exame)
    {
        $this->id_exame = $id_exame;

        return $this;
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function setDocumento($documento)
    {
        $this->documento = $documento;

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

    public function getExtensao()
    {
        return $this->extensao;
    }

    public function setExtensao($extensao)
    {
        $this->extensao = $extensao;

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
