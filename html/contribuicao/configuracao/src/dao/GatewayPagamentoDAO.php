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

class GatewayPagamentoDAO{

    private $pdo;

    public function __construct()
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->pdo;
    }

    /**
     * Inseri um gateway de pagamento no banco de dados da aplicação
     */
    public function cadastrar($nome, $endpoint, $token/*, $status*/){
        /*Lógica da aplicação */
        //definir consulta SQL
        $sqlCadastrar = "INSERT INTO contribuicao_gatewayPagamento (plataforma, endpoint, token) 
        VALUES (:plataforma, :endpoint, :token)";
        //utilizar prepared statements
        $stmt = $this->pdo->prepare($sqlCadastrar);
        $stmt->bindParam(':plataforma', $nome);
        $stmt->bindParam(':endpoint', $endpoint);
        $stmt->bindParam(':token', $token);
        //executar
        $stmt->execute();
    }

    /**
     * Busca os gateways de pagamento registrados no banco de dados da aplicação
     */
    public function buscaTodos(){
        //definir consulta sql
        $sqlBuscaTodos = "SELECT * from contribuicao_gatewayPagamento";
        //executar
        $resultado = $this->pdo->query($sqlBuscaTodos)->fetchAll(PDO::FETCH_ASSOC);
        //retornar resultado
        return $resultado;
    }
}