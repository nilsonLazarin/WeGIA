<?php
require_once 'ApiBoletoServiceInterface.php';
require_once '../model/ContribuicaoLog.php';
class PagarMeBoletoService implements ApiBoletoServiceInterface{
    public function gerarBoleto(ContribuicaoLog $contribuicaoLog){
        echo 'Entrou no serviço <br>';
        echo 'Contribuição log: ';
        print_r($contribuicaoLog);
        echo '<br>Sócio: ';
        print_r($contribuicaoLog->getSocio());
        return true;
    }
    public function guardarSegundaVia(){

    }
}