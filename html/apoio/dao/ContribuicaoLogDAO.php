<?php
//requisitar arquivo de conexão
require_once '../dao/ConexaoDAO.php';

//requisitar model
require_once '../model/ContribuicaoLog.php';

class ContribuicaoLogDAO{
    private $pdo;

    public function __construct(PDO $pdo = null)
    {
        if(is_null($pdo)){
            $this->pdo = ConexaoDAO::conectar();
        }else{
            $this->pdo = $pdo;
        }
    }

    public function criar(ContribuicaoLog $contribuicaoLog){
        $sqlInserirContribuicaoLog = 
            "INSERT INTO contribuicao_log (
                    id_socio,
                    id_gateway,
                    id_meio_pagamento, 
                    codigo, 
                    valor, 
                    data_geracao, 
                    data_vencimento, 
                    status_pagamento
                ) 
                VALUES (
                    :idSocio, 
                    :idGateway,
                    :idMeioPagamento,
                    :codigo, 
                    :valor, 
                    :dataGeracao, 
                    :dataVencimento, 
                    :statusPagamento
                )
            ";
        
        $stmt = $this->pdo->prepare($sqlInserirContribuicaoLog);
        $stmt->bindParam(':idSocio', $contribuicaoLog->getSocio()->getId());
        $stmt->bindParam(':idGateway', $contribuicaoLog->getGatewayPagamento()->getId());
        $stmt->bindParam(':idMeioPagamento', $contribuicaoLog->getMeioPagamento()->getId());
        $stmt->bindParam(':codigo', $contribuicaoLog->getCodigo());
        $stmt->bindParam(':valor', $contribuicaoLog->getValor());
        $stmt->bindParam(':dataGeracao', $contribuicaoLog->getDataGeracao());
        $stmt->bindParam(':dataVencimento', $contribuicaoLog->getDataVencimento());
        $stmt->bindParam(':statusPagamento', $contribuicaoLog->getStatusPagamento());

        $stmt->execute();

        $ultimoId = $this->pdo->lastInsertId();
        $contribuicaoLog->setId($ultimoId);

        return $contribuicaoLog;
    }

    public function alterarCodigoPorId($codigo, $id){
        $sqlPagarPorId = "UPDATE contribuicao_log SET codigo =:codigo WHERE id=:id";
        
        $stmt = $this->pdo->prepare($sqlPagarPorId);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    public function pagarPorId($id){
        $sqlPagarPorId = "UPDATE contribuicao_log SET status_pagamento = 1 WHERE id=:id";
        
        $stmt = $this->pdo->prepare($sqlPagarPorId);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }
}