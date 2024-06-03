<?php
require_once '../../classes/Util.php';

$cpfsValidos = [
   
]; //Insira aqui uma listagem de CPF's

$cpfsInvalidos = [
   
];//Insira aqui uma listagem de CPF's

$validador = new Util();

function loopTeste($validador, $cpfs, $msg)
{
    echo $msg. "\n";
    foreach ($cpfs as $cpf) {
        echo "CPF: $cpf - " . ($validador->validarCPF($cpf) ? "Válido" : "Inválido") . "\n";
    }
}

loopTeste($validador, $cpfsValidos, "Testando CPF's válidos");
loopTeste($validador, $cpfsInvalidos, "Testando CPF's inválidos");
