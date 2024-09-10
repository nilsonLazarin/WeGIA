<?php

//requisitar arquivo de conexão

$config_path = "config.php";
if (file_exists($config_path)) {
    require_once($config_path);
} else {
    while (true) {
        $config_path = "../" . $config_path;
        if (file_exists($config_path)) break;
    }
    require_once($config_path);
}

require_once ROOT . '/html/contribuicao/php/conexao.php';
class RegraPagamentoDAO{
    private $pdo;

    public function __construct()
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->pdo;
    }

    /**
     * Retorna todas as regras de contribuição presentes no banco de dados da aplicação
     */
    public function buscaRegrasContribuicao(){
        //definir consulta sql
        $sqlBuscaTodos = "SELECT * FROM contribuicao_regras";
        //executar
        $resultado = $this->pdo->query($sqlBuscaTodos)->fetchAll(PDO::FETCH_ASSOC);
        //retornar resultado
        return $resultado;
    }

    /**
     * Inseri um novo conjunto de regras no banco de dados da aplicação
     */
    public function cadastrar($meioPagamentoId, $regraContribuicaoId, $valor){
        /*Lógica da aplicação */
        //definir consulta SQL
        $sqlCadastrar = "INSERT INTO contribuicao_conjuntoRegras (id_meioPagamento, id_regra, valor) 
        VALUES (:meioPagamentoId, :regraContribuicaoId, :valor)";
        //utilizar prepared statements
        $stmt = $this->pdo->prepare($sqlCadastrar);
        $stmt->bindParam(':meioPagamentoId', $meioPagamentoId);
        $stmt->bindParam(':regraContribuicaoId', $regraContribuicaoId);
        $stmt->bindParam(':valor', $valor);
        //executar
        $stmt->execute();
    }
}