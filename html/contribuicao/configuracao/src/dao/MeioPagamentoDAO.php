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

class MeioPagamentoDAO{
    private $pdo;

    public function __construct()
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->pdo;
    }

    /**
     * Inseri um meio de pagamento no banco de dados da aplicação
     */
    public function cadastrar($descricao, $gatewayId){
        /*Lógica da aplicação */
        //definir consulta SQL
        $sqlCadastrar = "INSERT INTO contribuicao_meioPagamento (meio, id_plataforma) 
        VALUES (:descricao, :gatewayId)";
        //utilizar prepared statements
        $stmt = $this->pdo->prepare($sqlCadastrar);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':gatewayId', $gatewayId);
        //executar
        $stmt->execute();
    }

    /**
     * Retorna todos os meios de pagamentos registrados no banco de dados da aplicação
     */
    public function buscaTodos(){
        //definir consulta sql
        $sqlBuscaTodos = "SELECT * from contribuicao_meioPagamento";
        //executar
        $resultado = $this->pdo->query($sqlBuscaTodos)->fetchAll(PDO::FETCH_ASSOC);
        //retornar resultado
        return $resultado;
    }


    public function excluirPorId($id){
        //definir consulta sql
        $sqlExcluirPorId = "DELETE FROM contribuicao_meioPagamento WHERE id=:id";
        //utilizar prepared statements
        $stmt = $this->pdo->prepare($sqlExcluirPorId);
        $stmt->bindParam(':id', $id);
        //executar
        $stmt->execute();

        //verificar se algum elemento foi de fato excluído
        $meioPagamentoExcluido = $stmt->rowCount();

        if($meioPagamentoExcluido < 1){
            throw new Exception();
        }
    }
}