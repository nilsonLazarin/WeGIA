<?php
require_once '../model/ContribuicaoLog.php';
require_once '../dao/ContribuicaoLogDAO.php';
require_once '../model/Socio.php';
require_once '../dao/SocioDAO.php';

class ContribuicaoLogController
{
    public function criar()
    {
        $valor = filter_input(INPUT_POST, 'valor');
        $idSocio = filter_input(INPUT_POST, 'id_socio');

        //Verificar se existe um sócio que possua de fato o id
        $socioDao = new SocioDAO();
        $socio = $socioDao->buscarPorId($idSocio);

        if(is_null($socio)){
            //Colocar uma mensagem para informar que o sócio não existe
            exit();
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
            $contribuicaoLogDao = new ContribuicaoLogDAO();

            /*Implementar controle de transação para que o log só seja registrado
            caso o serviço de pagamento tenha sido executado*/
            $contribuicaoLogDao->criar($contribuicaoLog);
            //Fazer chamada do serviço de pagamento requisitado
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
