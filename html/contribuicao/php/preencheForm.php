<?php

	require_once('conexao.php');
	$banco = new Conexao();

//dados para tela de doacao:

	$banco->querydados("SELECT * FROM doacao_boleto_regras AS dbr JOIN doacao_boleto_info AS dbi ON (dbr.id = dbi.id_regras)");
	$result =  $banco->result();
	$dado = $banco->rows();
		if($dado == 0)
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
			$id_sistema = 3;
		}else{
			$op0 = $result['dias_venc_carne_op1'];
			$op1 = $result['dias_venc_carne_op2'];
			$op2 = $result['dias_venc_carne_op3'];
			$op3 = $result['dias_venc_carne_op4'];
			$op4 = $result['dias_venc_carne_op5'];
			$op5 = $result['dias_venc_carne_op6'];
			$minvalunic = $result['min_boleto_uni'];
			$valminparc = $result['min_parcela'];
			$valmaxparc = $result['max_parcela'];
			$id_sistema = $result['id_sistema'];
		}

	
	$banco->querydados("SELECT link, valor FROM doacao_cartao_mensal");
	$dadoInicialCartao = $banco->result();
	$dadosCartao = $banco->arraydados();
	$linhas = $banco->rows();

	$banco->querydados("SELECT url FROM doacao_cartao_avulso AS ca JOIN sistema_pagamento AS sp ON (ca.id_sistema = sp.id) WHERE nome_sistema = 'PAYPAL'");
	$fetch = $banco->result();
		if(empty($fetch['url']))
		{
			$linkPaypal = "https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XX32RXEYVQS6G&source=url";
		}else{
			$linkPaypal = $fetch['url'];
		}		
	

	$banco->querydados("SELECT url FROM doacao_cartao_avulso AS ca JOIN sistema_pagamento AS sp ON (ca.id_sistema = sp.id) WHERE nome_sistema = 'PAGSEGURO'");
	$fetch = $banco->result();
		if(empty($fetch['url']))
		{
			$linkPagSeguro = "http://pag.ae/bks9DRw";
		}else{
			$linkPagSeguro = $fetch['url'];
		}

?>