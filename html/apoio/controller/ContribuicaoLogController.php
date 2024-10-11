<?php
require_once '../model/ContribuicaoLog.php';
require_once '../dao/ContribuicaoLogDAO.php';
require_once '../model/Socio.php';
require_once '../dao/SocioDAO.php';
require_once '../dao/MeioPagamentoDAO.php';
require_once '../dao/GatewayPagamentoDAO.php';
require_once '../model/GatewayPagamento.php';
require_once '../model/ContribuicaoLogCollection.php';

class ContribuicaoLogController
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = ConexaoDAO::conectar();
    }

    public function criarBoleto() //Talvez seja melhor separar em: criarBoleto, criarCarne e criarPix
    {
        $valor = filter_input(INPUT_POST, 'valor');
        $documento = filter_input(INPUT_POST, 'documento_socio');
        $formaPagamento = 'Boleto';

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
            $requisicaoServico = '../service/' . $gatewayPagamento->getNome() . $formaPagamento . 'Service' . '.php';

            if (!file_exists($requisicaoServico)) {
                //implementar feedback
                exit('Arquivo não encontrado');
            }

            require_once $requisicaoServico;

            $classeService = $gatewayPagamento->getNome() . $formaPagamento . 'Service';

            if (!class_exists($classeService)) {
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

    public function criarCarne()
    {
        $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
        $documento = filter_input(INPUT_POST, 'documento_socio');
        $qtdParcelas = filter_input(INPUT_POST, 'parcelas', FILTER_VALIDATE_INT);
        $diaVencimento = filter_input(INPUT_POST, 'dia-vencimento', FILTER_VALIDATE_INT);
        $formaPagamento = 'Carne';

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
            $requisicaoServico = '../service/' . $gatewayPagamento->getNome() . $formaPagamento . 'Service' . '.php';

            if (!file_exists($requisicaoServico)) {
                //implementar feedback
                exit('Arquivo não encontrado');
            }

            require_once $requisicaoServico;

            $classeService = $gatewayPagamento->getNome() . $formaPagamento . 'Service';

            if (!class_exists($classeService)) {
                //implementar feedback
                exit('Classe não encontrada');
            }

            $servicoPagamento = new $classeService;
        } catch (PDOException $e) {
            //implementar tratamento de erro
            echo 'Erro: ' . $e->getMessage();
            exit();
        }

        //Criar coleção de contribuições
        $contribuicaoLogCollection = new ContribuicaoLogCollection();

        if (!$qtdParcelas || $qtdParcelas < 2) {
            //implementar mensagem de erro
            exit('O mínimo de parcelas deve ser 2');
        }

        // Pegar a data atual
        $dataAtual = new DateTime();

        // Verificar se o dia informado já passou neste mês
        if ($diaVencimento <= $dataAtual->format('d')) {
            // Se o dia informado já passou, começar a partir do próximo mês
            $dataAtual->modify('first day of next month');
        }

        for ($i = 0; $i < $qtdParcelas; $i++) {
            // Clonar a data atual para evitar modificar o objeto original
            $dataVencimento = clone $dataAtual;

            // Adicionar os meses de acordo com o índice da parcela
            $dataVencimento->modify("+{$i} month");

            // Definir o dia do vencimento para o dia informado
            $dataVencimento->setDate($dataVencimento->format('Y'), $dataVencimento->format('m'), $diaVencimento);

            // Ajustar a data caso o mês não tenha o dia informado (por exemplo, 30 de fevereiro)
            if ($dataVencimento->format('d') != $diaVencimento) {
                $dataVencimento->modify('last day of previous month');
            }

            $contribuicaoLog = new ContribuicaoLog();
            $contribuicaoLog
                ->setValor($valor)
                ->setCodigo($contribuicaoLog->gerarCodigo())
                ->setDataGeracao($dataAtual->format('Y-m-d'))
                ->setDataVencimento($dataVencimento->format('Y-m-d'))
                ->setSocio($socio);

            //Inserir na coleção
            $contribuicaoLogCollection->add($contribuicaoLog);
        }

        try {
            /*Controle de transação para que o log só seja registrado
            caso o serviço de pagamento tenha sido executado*/
            $this->pdo->beginTransaction();

            foreach ($contribuicaoLogCollection as $contribuicaoLog) {
                $contribuicaoLogDao = new ContribuicaoLogDAO($this->pdo);
                $contribuicaoLogDao->criar($contribuicaoLog);
            }

            //Chamada do método de serviço de pagamento requisitado
            if (!$servicoPagamento->gerarCarne($contribuicaoLogCollection)) {
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
