<?php
require_once '../model/ContribuicaoLog.php';
require_once '../dao/ContribuicaoLogDAO.php';
require_once '../model/Socio.php';
require_once '../dao/SocioDAO.php';
require_once '../dao/MeioPagamentoDAO.php';
require_once '../dao/GatewayPagamentoDAO.php';
require_once '../model/GatewayPagamento.php';

class ContribuicaoLogController
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = ConexaoDAO::conectar();
    }

    public function criar()//Talvez seja melhor separar em: criarBoleto, criarCarne e criarPix
    {
        $valor = filter_input(INPUT_POST, 'valor');
        $documento = filter_input(INPUT_POST, 'documento_socio');
        $formaPagamento = filter_input(INPUT_POST, 'forma_pagamento');

        //Verificar se existe um sócio que possua de fato o documento
        try {
            $socioDao = new SocioDAO();
            $socio = $socioDao->buscarPorDocumento($documento);

            if (is_null($socio)) {
                //Colocar uma mensagem para informar que o sócio não existe
                exit('Sócio não encontrado');
            }

            //$servicoPagamento = Verificar qual a melhor maneira de detectar o serviço de pagamento
            $meioPagamentoDao = new MeioPagamentoDAO();
            $meioPagamento = $meioPagamentoDao->buscarPorNome($formaPagamento);

            if (is_null($meioPagamento)) {
                //Colocar uma mensagem para informar que o meio de pagamento não existe
                exit('Meio de pagamento não encontrado');
            }

            //Procura pelo serviço de pagamento através do id do gateway de pagamento
            $gatewayPagamentoDao = new GatewayPagamentoDAO();
            $gatewayPagamentoArray = $gatewayPagamentoDao->buscarPorId($meioPagamento->getGatewayId());
            $gatewayPagamento = new GatewayPagamento($gatewayPagamentoArray['plataforma'], $gatewayPagamentoArray['endPoint'], $gatewayPagamentoArray['token'], $gatewayPagamentoArray['status']);

            //Requisição dinâmica e instanciação da classe com base no nome do gateway de pagamento
            $requisicaoServico = '../service/'.$gatewayPagamento->getNome().$formaPagamento.'Service'.'.php';

            if(!file_exists($requisicaoServico)){
                //implementar feedback
                exit('Arquivo não encontrado');
            }

            require_once $requisicaoServico;
            
            $classeService = $gatewayPagamento->getNome().$formaPagamento.'Service';

            if(!class_exists($classeService)){
                //implementar feedback
                exit('Classe não encontrada');
            }

            $servicoPagamento = new $classeService;
        } catch (PDOException $e) {
            //implementar tratamento de erro
            echo 'Erro: ' . $e->getMessage();
            exit();
        }

        //Verificar qual fuso horário será utilizado posteriormente
        $dataGeracao = date('Y-m-d');
        $dataVencimento = date_modify(new DateTime(), '+7 day')->format('Y-m-d');

        $contribuicaoLog = new ContribuicaoLog();
        $contribuicaoLog
            ->setValor($valor)
            ->setCodigo($contribuicaoLog->gerarCodigo())
            ->setDataGeracao($dataGeracao)
            ->setDataVencimento($dataVencimento)
            ->setSocio($socio);

        try {
            /*Controle de transação para que o log só seja registrado
            caso o serviço de pagamento tenha sido executado*/
            $this->pdo->beginTransaction();
            $contribuicaoLogDao = new ContribuicaoLogDAO($this->pdo);
            $contribuicaoLogDao->criar($contribuicaoLog);
            //Chamada do método de serviço de pagamento requisitado
            if (!$servicoPagamento->gerarBoleto($contribuicaoLog)) {
                $this->pdo->rollBack();
            } else {
                $this->pdo->commit();
            }
        } catch (PDOException $e) {
            //implementar tratamento de erro
            echo 'Erro: ' . $e->getMessage();
        }
    }

    public function pagarPorId()
    {
        $idContribuicaoLog = filter_input(INPUT_POST, 'id_contribuicao');

        if (!$idContribuicaoLog || $idContribuicaoLog < 1) {
            http_response_code(400);
            exit('O id fornecido não é válido'); //substituir posteriormente por redirecionamento com mensagem de feedback
        }

        try {
            $contribuicaoLogDao = new ContribuicaoLogDAO();
            $contribuicaoLogDao->pagarPorId($idContribuicaoLog);
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage(); //substituir posteriormente por redirecionamento com mensagem de feedback
        }
    }
}
