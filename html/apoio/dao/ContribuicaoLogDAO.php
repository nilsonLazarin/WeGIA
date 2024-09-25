<?php
//requisitar arquivo de conexão
require_once '../dao/ConexaoDAO.php';

//requisitar model
require_once '../model/ContribuicaoLog.php';

class ContribuicaoLogDAO{
    private $pdo;

    public function __construct()
    {
        $this->pdo = ConexaoDAO::conectar();
    }

    public function criar(ContribuicaoLog $contribuicaoLog){
        $sqlInserirContribuicaoLog = "INSERT INTO contribuicao_log (
                    id_socio, 
                    codigo, 
                    valor, 
                    data_geracao, 
                    data_vencimento, 
                    status_pagamento
                ) 
                VALUES (
                    :idSocio, 
                    :codigo, 
                    :valor, 
                    :dataGeracao, 
                    :dataVencimento, 
                    :statusPagamento
                )
            ";
        
        $stmt = $this->pdo->prepare($sqlInserirContribuicaoLog);
        $stmt->bindParam(':idSocio', $contribuicaoLog->getIdSocio());
        $stmt->bindParam(':codigo', $contribuicaoLog->getCodigo());
        $stmt->bindParam(':valor', $contribuicaoLog->getValor());
        $stmt->bindParam(':dataGeracao', $contribuicaoLog->getDataGeracao());
        $stmt->bindParam(':dataVencimento', $contribuicaoLog->getDataVencimento());
        $stmt->bindParam(':statusPagamento', $contribuicaoLog->getStatusPagamento());

        $stmt->execute();
    }
}