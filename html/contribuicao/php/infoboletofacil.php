<?php

include("conexao.php");

    $select = "SELECT * FROM doacao_boleto_info AS bi JOIN sistema_pagamento AS sp ON (bi.id_sistema = sp.id) JOIN doacao_boleto_regras AS br ON (br.id = bi.id_regras)  WHERE nome_sistema = 'BOLETOFACIL'";
    $query = mysqli_query($conexao, $select);
    $linhas = mysqli_affected_rows($conexao);

        if($linhas != 1)
        {
            $array['API'] = 'https://sandbox.boletobancario.com/boletofacil/integration/api/v1/issue-charge?';
            $array['token'] = 'FE2A4FC9B15FEBE651F9C50C4E1774EB365827849E04A711F9D0E02C1ACFAD13';
            $array['maxOverDueDays_carne']= '29';
            $array['agradecimento']='Obrigado por sua doação!';
            $array['maxOverDays_Unico']='3';
        }else
            {
                $registro = mysqli_fetch_row($query);
                $api = $registro[1];
                $token = $registro[2];
                $idregras = $registro[6];
                $maxOverdueDays = $registro[11];
                $maxValorParc = $registro[14];
                $minValorParc = $registro[15];
                $agradecimento = $registro[16];
                $maxDaysUnico = $registro[17];
                
                $array['API'] = $api;
                $array['token']=$token;
                $array['maxOverDueDays_carne']=$maxOverdueDays;
                $array['max_valor_parcela']=$maxValorParc;
                $array['min_valor_parc']=$minValorParc;
                $array['agradecimento']=$agradecimento;
                $array['maxOverDays_Unico']=$maxDaysUnico;

                echo(json_encode($array));
            }

    
?>