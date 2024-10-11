<?php 
require_once '../model/ContribuicaoLogCollection.php';
require_once '../model/ContribuicaoLog.php';
require_once 'ApiCarneServiceInterface.php';
class PagarMeCarneService implements ApiCarneServiceInterface{
    public function gerarCarne(ContribuicaoLogCollection $contribuicaoLogCollection)
    {
        //Implementar geração de carnê
    }

    public function guardarSegundaVia()
    {
        
    }
}