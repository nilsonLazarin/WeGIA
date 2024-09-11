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

    public function buscaConjuntoRegrasPagamento(){
         //definir consulta sql
         $sqlBuscaTodos = "SELECT ccr.id, ccr.id_meioPagamento, ccr.id_regra, ccr.valor, cmp.meio, cr.regra, cgp.plataforma, cgp.endpoint   
         FROM contribuicao_conjuntoRegras ccr 
         JOIN contribuicao_meioPagamento cmp ON(cmp.id=ccr.id_meioPagamento) 
         JOIN contribuicao_gatewayPagamento cgp ON(cgp.id = cmp.id_plataforma) 
         JOIN contribuicao_regras cr ON(cr.id=ccr.id_regra)";
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


    public function excluirPorId($id){
        //definir consulta sql
        $sqlExcluirPorId = "DELETE FROM contribuicao_conjuntoRegras WHERE id=:id";
        //utilizar prepared statements
        $stmt = $this->pdo->prepare($sqlExcluirPorId);
        $stmt->bindParam(':id', $id);
        //executar
        $stmt->execute();

        //verificar se algum elemento foi de fato excluído
        $conjuntoRegraPagamentoExcluido = $stmt->rowCount();

        if($conjuntoRegraPagamentoExcluido < 1){
            throw new Exception();
        }
    }
}