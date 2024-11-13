<?php

function mensalidadeInterna(int $intervalo)
{
    $datasVencimento = [];

    $diaVencimento = ($_POST['dia']);

    $qtd_p = intval($_POST['parcela']);

    if (empty($diaVencimento)) {
        echo json_encode('O dia de vencimento de uma parcela não pode ser vazio');
        exit();
    }

    $dia = explode('-', $diaVencimento)[2];

    // Pegar a data informada
    $dataAtual = new DateTime($diaVencimento);

    // Iterar sobre a quantidade de parcelas
    for ($i = 0; $i < $qtd_p; $i++) {
        // Clonar a data atual para evitar modificar o objeto original
        $dataVencimento = clone $dataAtual;

        //incremento de meses
        $incremento = $intervalo * $i;

        // Adicionar os meses de acordo com o índice da parcela
        $dataVencimento->modify("+{$incremento} month");

        //verificar se o dia de dataVencimento é diferente de $dia, se forem diferentes
        //subtrair um mês e modificar para o último dia
        if ($dataVencimento->format('d') != $dia) {
            $dataVencimento->modify('last day of previous month');
        }

        // Adicionar a data formatada ao array
        $datasVencimento[] = $dataVencimento->format('Y-m-d');
    }
    return $datasVencimento;
}
