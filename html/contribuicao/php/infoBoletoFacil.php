<?php

    boletoFacil();

    function boletoFacil()
    {
        require_once('conexao.php');
        $query = new Conexao();

            $query->querydados("SELECT * FROM doacao_boleto_info AS bi JOIN sistema_pagamento AS sp ON (bi.id_sistema = sp.id) JOIN doacao_boleto_regras AS br ON (br.id = bi.id_regras)  WHERE nome_sistema = 'BOLETOFACIL'");
            if($query->rows() == 0)
            {
                dadosIniciais();
            }else{
                $result = $query->result();
                echo (json_encode($result));
            }
          
    }
    

    function dadosIniciais()
    {
            $array['API'] = 'https://sandbox.boletobancario.com/boletofacil/integration/api/v1/issue-charge?';
            $array['token'] = 'FE2A4FC9B15FEBE651F9C50C4E1774EB365827849E04A711F9D0E02C1ACFAD13';
            $array['maxOverDueDays_carne']= '29';
            $array['agradecimento']='Obrigado por sua doação!';
            $array['maxOverDays_Unico']='3';

            echo(json_encode($array));
    }

    
?>
