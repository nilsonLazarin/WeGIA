<?php
require_once '../../classes/Funcionario.php';

$dataMaxima = Funcionario::getDataNascimentoMaxima();
echo 'Data de nascimento máxima: '.$dataMaxima;

echo PHP_EOL;

$dataMinima = Funcionario::getDataNascimentoMinima();
echo 'Data de nascimento mínima: '.$dataMinima;