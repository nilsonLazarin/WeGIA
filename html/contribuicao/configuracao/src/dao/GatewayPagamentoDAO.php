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

    public function excluirPorId($id){
        //definir consulta sql
        $sqlExcluirPorId = "DELETE FROM contribuicao_gatewayPagamento WHERE id=:id";
        //utilizar prepared statements
        $stmt = $this->pdo->prepare($sqlExcluirPorId);
        $stmt->bindParam(':id', $id);
        //executar
        $stmt->execute();

        //verificar se algum elemento foi de fato excluído
        $gatewayExcluido = $stmt->rowCount();

        if($gatewayExcluido < 1){
            throw new Exception();
        }
    }

    /**
     * Modifica os campos da tabela contribuicao_gatewaypagamento relacionados ao id informado
     */
    public function editarPorId($id, $nome, $endpoint, $token){
        //definir consulta sql
        $sqlEditarPorId = "UPDATE contribuicao_gatewayPagamento SET plataforma =:nome, endpoint =:endpoint, token =:token WHERE id=:id";
        //utilizar prepared statements
        $stmt = $this->pdo->prepare($sqlEditarPorId);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':endpoint', $endpoint);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':id', $id);
        //executar
        $stmt->execute();

        //verificar se algum elemento foi de fato alterado
        $gatewayExcluido = $stmt->rowCount();

        if($gatewayExcluido < 1){
            throw new Exception();
        }
    }
}