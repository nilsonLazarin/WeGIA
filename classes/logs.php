<?php
require_once ('acesso.php');

require_once ('logs.php');

class Logs
{

    // Atributos da classe
    private $idlogs;

    private $idusuarios;

    private $queryexecutada;

    private $tabela;

    private $acao;

    private $dtreg;

    // Insert
    public function Incluir($idusuarios, $queryexecutada, $tabela, $acao)
    {
        try {
            
            $query_executada = str_replace("'", "\'", $query_executada);
            
            $dtreg = date('Y-m-d H:i:s');
            
            $sql = "insert into logs (idusuarios,queryexecutada,tabela,acao,dtreg) values 

		(:idusuarios , :queryexecutada, :tabela , :acao , :dtreg)";
            
            $sql = str_replace("'", "\'", $sql);
            
            $Acesso = new Acesso();
            
            $pdo = $Acesso->conexao();
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':idusuarios', $idusuarios);
            
            $stmt->bindParam(':queryexecutada', $queryexecutada);
            
            $stmt->bindParam(':tabela', $tabela);
            
            $stmt->bindParam(':acao', $acao);
            
            $stmt->bindParam(':dtreg', $dtreg);
            
            $stmt->execute();
        } catch (PDOException $e) {
            
            echo 'Error: <b> na tabela Logs = ' . $sql . "</b> <br />" . $e->getMessage();
        }
    }

    // consultar
    public function consultar($sql)
    {
        $acesso = new Acesso();
        
        $acesso->conexao();
        
        $acesso->query($sql);
        
        $this->Linha = $acesso->linha;
        
        $this->Result = $acesso->result;
    }
}

?>
