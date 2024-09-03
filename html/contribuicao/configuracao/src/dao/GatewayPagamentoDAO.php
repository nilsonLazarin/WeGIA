<?php
//requisitar arquivo de conexão
require_once '../../../php/conexao.php';

class GatewayPagamentoDAO{

    private $pdo;

    public function __construct()
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->pdo;
    }

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
}