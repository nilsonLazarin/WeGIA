<?php

//preenchendo o formulário com as opções determinadas no banco;

	$select = mysqli_query($conexao, "select * from doacao_boleto_regras");
	$result = mysqli_num_rows($select);
	$fetch = mysqli_fetch_row($select);
		if($result == 0)
		{
			$op0 = 1;
			$op1 = 5;
			$op2 = 10;
			$op3 = 15;
			$op4 = 20;
			$op5 = 25;
			$minvalunic = '10.00';
			$valminparc = '30.00';
			$valmaxparc = '1000.00';
		}else{
			$op0 = $fetch[9];
			$op1 = $fetch[10];
			$op2= $fetch[11];
			$op3 = $fetch[12];
			$op4 =$fetch[13];
			$op5 = $fetch[14];
			$minvalunic = $fetch[1];
			$valminparc = $fetch[6];
			$valmaxparc = $fetch[5];
		}
    
	$querycartao = mysqli_query($conexao, "select * from doacao_cartao_mensal");
	$qtd = mysqli_num_rows($querycartao);

	$paypal_card = mysqli_query($conexao, "select url from doacao_cartao_avulso as ca join sistema_pagamento as sp on (ca.id_sistema = sp.id) where nome_sistema = 'PAYPAL'");
	$result_paycard = mysqli_num_rows($paypal_card);
		if($result_paycard == 0)
		{
			$paypal = "https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XX32RXEYVQS6G&source=url";
		}else{
			$fetch_link = mysqli_fetch_row($paypal_card);
			$paypal = $fetch_link[0];
		}
	$pagseguro_card = mysqli_query($conexao, "select url from doacao_cartao_avulso as ca join sistema_pagamento as sp on (ca.id_sistema = sp.id) where nome_sistema = 'PAGSEGURO'");
	$result_pagcard = mysqli_num_rows($pagseguro_card);
		if($result_pagcard == 0)
			{
				$pagseguro = "http://pag.ae/bks9DRw";
			}else{
				$fetch_link = mysqli_fetch_row($pagseguro_card);
				$pagseguro = $fetch_link[0];
            }
            
?>