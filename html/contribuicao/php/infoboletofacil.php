<?php

include("conexao.php");

    $select = "select * from doacao_boleto_info where id = 0";
    $query = mysqli_query($conexao, $select);
    $linhas = mysqli_affected_rows($conexao);

        if($linhas != 1)
        {
            echo "erro!";
        }else
            {
                $registro = mysqli_fetch_row($query);
                $api = $registro[1];
                $token = $registro[2];
                $idregras = $registro[6];
            }

    $regrassql = "select * from doacao_boleto_regras where id = '$idregras'";
    $queryregras = mysqli_query($conexao, $regrassql);
    $linhasregras = mysqli_affected_rows($conexao);

            if($linhasregras != 1)
            {
                echo "erro!";
            }else
                {
                    $regras = mysqli_fetch_row($queryregras);
                    $maxOverdueDays = $regras[2];
                    $maxValorParc = $regras[5];
                    $minValorParc = $regras[6];
                    $agradecimento = $regras[7];
                    $maxDaysUnico = $regras[8];
                }

    $array['API'] = $api;
    $array['token']=$token;
    $array['maxOverDueDays_carne']=$maxOverdueDays;
    $array['max_valor_parcela']=$maxValorParc;
    $array['min_valor_parc']=$minValorParc;
    $array['agradecimento']=$agradecimento;
    $array['maxOverDays_Unico']=$maxDaysUnico;

    echo(json_encode($array));
?>