<?php
require_once 'ApiBoletoServiceInterface.php';
require_once '../model/ContribuicaoLog.php';
class PagarMeBoletoService implements ApiBoletoServiceInterface{
    public function gerarBoleto(ContribuicaoLog $contribuicaoLog){
        //gerar um número para o documento
        $numeroDocumento = $this->gerarNumeroDocumento(16);
        return true;
    }
    public function guardarSegundaVia(){

    }

    /**
     * Retorna um número com a quantidade de algarismos informada no parâmetro
     */
    public function gerarNumeroDocumento($tamanho){
        $numeroDocumento = '';

        for($i=0; $i < $tamanho; $i++){
            $numeroDocumento .= rand(0,9);
        }

        return intval($numeroDocumento);
    }
}