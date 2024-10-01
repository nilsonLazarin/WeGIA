<?php
require_once '../model/ContribuicaoLog.php';
require_once '../dao/ContribuicaoLogDAO.php';
require_once '../model/Socio.php';
require_once '../dao/SocioDAO.php';

//Fazer requisição dinâmica posteriormente
require_once '../service/PagarMeBoletoService.php';

class ContribuicaoLogController
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = ConexaoDAO::conectar();
    }

    public function criar()
    {
        $valor = filter_input(INPUT_POST, 'valor');
        $documento = filter_input(INPUT_POST, 'documento_socio');

        //Verificar se existe um sócio que possua de fato o id
        $socioDao = new SocioDAO();
        $socio = $socioDao->buscarPorDocumento($documento);

        if(is_null($socio)){
            //Colocar uma mensagem para informar que o sócio não existe
            exit('Sócio não encontrado');
        }

        //$servicoPagamento = Verificar qual a melhor maneira de detectar o serviço de pagamento

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
            /*Implementar controle de transação para que o log só seja registrado
            caso o serviço de pagamento tenha sido executado*/
            $this->pdo->beginTransaction();
            $contribuicaoLogDao = new ContribuicaoLogDAO($this->pdo);
            $contribuicaoLogDao->criar($contribuicaoLog);
            //Fazer chamada do serviço de pagamento requisitado
            $servicoPagamento = new PagarMeBoletoService();//Chamar dinamicamente
            if(!$servicoPagamento->gerarBoleto($contribuicaoLog)){
                $this->pdo->rollBack();
            }else{
                $this->pdo->commit();
            }
        } catch (PDOException $e) {
            //implementar tratamento de erro
            echo 'Erro: '.$e->getMessage();
        }
    }

    public function pagarPorId(){
        $idContribuicaoLog = filter_input(INPUT_POST, 'id_contribuicao');

        if(!$idContribuicaoLog || $idContribuicaoLog < 1){
            http_response_code(400);
            exit('O id fornecido não é válido');//substituir posteriormente por redirecionamento com mensagem de feedback
        }

        try{
            $contribuicaoLogDao = new ContribuicaoLogDAO();
            $contribuicaoLogDao->pagarPorId($idContribuicaoLog);
        }catch(PDOException $e){
            echo 'Erro: '.$e->getMessage(); //substituir posteriormente por redirecionamento com mensagem de feedback
        }
    }
}
