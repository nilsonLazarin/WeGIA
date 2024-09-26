<?php
require_once '../model/ContribuicaoLog.php';
interface ApiBoletoServiceInterface{
    public function gerarBoleto(ContribuicaoLog $contribuicaoLog);
    public function guardarSegundaVia();
    /*Adicionar mais métodos posteriormente */
}