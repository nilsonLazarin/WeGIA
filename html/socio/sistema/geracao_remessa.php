<?php
 	require("../conexao.php");
	 $config_path = "config.php";
	 if(file_exists($config_path)){
		 require_once($config_path);
	 }else{
		 while(true){
			 $config_path = "../" . $config_path;
			 if(file_exists($config_path)) break;
		 }
		 require_once($config_path);
	}
	$req = mysqli_query($conexao, "SELECT `id`, `codigo`, `data_emissao` FROM `remessa` ORDER BY `id` DESC LIMIT 1");
	 
	$conexao->close();
	 
	$dia = date("d");
	
	$mes = date("m");

	$ano = date("Y");

		

	if($req->num_rows > 0){
		$row = $req->fetch_assoc();
		$id = intval($row["id"])+1;  //Pega o último id registrado e soma 1	
		$data_atual = "$ano-$mes-$dia";
		$codigo_antes = $row["codigo"];
		if(strlen($row["codigo"])==1){
			$row["codigo"] = '0' . $row["codigo"];
		}
		$codigo_desf = str_split($row["codigo"]); //código desformatado
		$data_e_a = $row["data_emissao"]; //data de emissão anterior
		$data_e_a = new DateTime($data_e_a);
		$data_atual = new DateTime ($data_atual);
		$diferenca_datas = $data_atual->diff($data_e_a);
		if($diferenca_datas->d == 0){  // Cria o código do arquivo com padrão do Bradesco. Ele segue os detalhes dos campos '??' no layout de remessa Bradesco. 
			$dig1_ant = $codigo_desf[0];
			$dig2_ant = $codigo_desf[1];
			if(is_numeric($dig2_ant)){
				if(intval($dig2_ant)==9){
					$dig2_atual = 'A';
				}
				else{
					$dig2_atual = intval($dig2_ant)+1;
				}
				$codigo = strval($dig1_ant.$dig2_atual);
			}
			else{
				if($dig2_ant=='Z'){
					if(is_numeric($dig1_ant)){
						if(intval($dig1_ant)==9){
							$dig1_atual = 'A';
						}
						else{
							$dig1_atual = intval($dig1_ant)+1;
						}
					}
					else if ($dig1_ant=='Z'){
						$obj = [
							'parar'=>true
						];
						$obj = json_encode($obj);
						echo $obj;
						die();
					}
					else{
						$dig1_atual = ord($dig1_ant)+1;
						$dig1_atual = chr($dig1_atual);
					}
					$dig2_atual = '0';
				}
				else{
					$dig2_atual = ord($dig2_ant)+1;
					$dig2_atual = chr($dig2_atual);
					$dig1_atual = $dig1_ant;
				}
				$codigo = strval($dig1_atual.$dig2_atual);
			}
			
		}
		else{
			$codigo = "00";
		}
	}
	else{
		$id = "01";
		$codigo = "00";
	} 
	
	 $dataVencimento = $_POST['dataVencimento'];
	 $tipo_inscricao = $_POST['tipo_inscricao'];
	 $valor = $_POST['valor'];
	 $nome = $_POST['nome'];
	 $cidade = $_POST['cidade'];
	 $cpf_cnpj = $_POST['cpf_cnpj'];
	 
	$_POST['cidade'] == "" || $_POST['cidade'] == null ? $cidade = "desconhecido" : $cidade = $_POST['cidade'];

	$_POST['logradouro'] == "" || $_POST['logradouro'] == null ? $logradouro = "sem endereco" : $logradouro = $_POST['logradouro'];

	$_POST['estado'] == "" || $_POST['estado'] == null ? $estado = "NN" : $estado = $_POST['estado'];

	$_POST['cep'] == "" || $_POST['cep'] == null ? $cep = "28600000" : $cep = $_POST['cep'];

	$_POST['complemento'] == "" || $_POST['complemento'] == null ? $complemento = "" : $complemento = $_POST['complemento'];

	$_POST['bairro'] == "" || $_POST['bairro'] == null ? $bairro = "sem bairro" : $bairro = $_POST['bairro'];

	$_POST['numero_end'] == "" || $_POST['numero_end'] == null ? $numero_end = "" : $numero_end = $_POST['numero_end'];

	$filedir = BKP_DIR."arquivos_rem";
	if(is_dir($filedir)){
		$existe = 1;
	}
	
	
	// Converte a UF do estado para maiúsculas
	$estado = strtoupper($estado);

	$datasFormatadas = array();
	foreach ($dataVencimento as $data){
		$datasFormatadas[] = str_replace("/", "", $data);
	}


# FUNÇOES

if(!function_exists(limit))

	{

		function limit($palavra,$limite)

		{

			if(strlen($palavra) >= $limite)

			{

				$var = substr($palavra, 0,$limite);

			}

			else

			{

				$max = (int)($limite-strlen($palavra));

				$var = $palavra.complementoRegistro($max,"brancos");

			}

			return $var;

		}

	}



if(!function_exists(sequencial))

	{

		function sequencial($i)

		{

			if($i < 10)

			{

				return zeros(0,5).$i;

			}

			else if($i > 10 && $i < 100)

			{

				return zeros(0,4).$i;

			}

			else if($i > 100 && $i < 1000)

			{

				return zeros(0,3).$i;

			}

			else if($i > 1000 && $i < 10000)

			{

				return zeros(0,2).$i;

			}

			else if($i > 10000 && $i < 100000)

			{

				return zeros(0,1).$i;

			}

		}

	}



if(!function_exists(zeros))

	{

		function zeros($min,$max)

		{

			$x = ($max - strlen($min));

			for($i = 0; $i < $x; $i++)

			{

				$zeros .= '0';

			}

			return $zeros.$min;

		}

	}



if(!function_exists(complementoRegistro))

	{

		function complementoRegistro($int,$tipo)

		{

			if($tipo == "zeros")

			{

				$space = '';

				for($i = 1; $i <= $int; $i++)

				{

					$space .= '0';

				}

			}

			else if($tipo == "brancos")

			{

				$space = '';

				for($i = 1; $i <= $int; $i++)

				{

					$space .= ' ';

				}

			}

			

			return $space;

		}

	}



if(!function_exists(formata_numdoc))

	{

		function formata_numdoc($num,$tamanho)

			{

				while(strlen($num)<$tamanho)

					{

						$num="0".$num; 

					}

				return $num;

			}

	}



	#### Código do banco

	$codigo_banco = '237';



	################################

	# DADOS PARA TESTE, COLOQUE OS DADOS DO EMISSOR DO BOLETO

	$dados2[cpf_cnpj_con] = '00.068.903/0001-04';

	$dados2[agencia_con] = '2813-4';

	$dados2[conta_con] = '30000-4';

	$dados2[carteira_con] = '09';

	$dados2[convenio_con] = '5718204';

	$dados2[cedente_con] = 'Lar Abrigo Amor a Jesus';
	$dados["cep_cli"] = $cep;


	# DADOS DO BOLETO

	$id_rem = $id; # Crie aqui um código sequencial

	$dados["id_cob"] = $id_rem; # Número do pedido ou referência que voce queira usar pra identificar o boleto

	$dados["valor_cob"] = $valor;

	$dados["data_vencimento_cob_f"] = $dataVencimento; #DiaMesAno



	# DADOS DO CLIENTE

	$dados["tipo_inscricao"] = $tipo_inscricao; # 2-CNPJ      1-CPF

	$dados["documento_cliente"] = $cpf_cnpj;

	$dados["cliente_fornecedor"] = $nome;

	$dados["endereco_cli"] = $numero_end !== "" ? "$logradouro, $numero_end" : $logradouro;

	$dados["bairro_cli"] = $bairro;

	$dados["desc_cid"] =$cidade;

	$dados["desc_est"] = $estado;


	################################



	$hora = formata_numdoc(date("H"),2);

	$minuto = formata_numdoc(date("m"),2);

	$segundo = formata_numdoc(date("s"),2);





	$codigo = formata_numdoc($codigo,2);





	$nomeParaDownload = "CB$dia$mes$codigo.rem"; // Será passado para o javascript
	$filename = $filedir."/CB$dia$mes$codigo.rem";

	$conteudo = '';



	$parametro = htmlspecialchars($id_par_grupo);

	$total = substr_count($parametro, ',');

	$parametro = explode(",",htmlspecialchars($parametro));


	# Pega configuraçoes da SRC Cred

	$cnpj = str_replace('.','',$dados2[cpf_cnpj_con]);

	$cnpj = str_replace('-','',$cnpj);

	$cnpj = str_replace('/','',$cnpj);

															

	$agencia = explode("-",$dados2[agencia_con]);

	$agencia_digito = $agencia[1];

	$agencia = $agencia[0];



	$conta = explode("-",$dados2[conta_con]);

	$conta_digito = $conta[1];

	$conta = $conta[0];

	$carteira = substr($dados2[carteira_con],1,1);



	$convenio = $dados2[convenio_con];



	$cedente_con = $dados2[cedente_con];

	# Removendo acentuacao

	$acentosParaNaoAcentos = array(
		'Á' => 'A', 'À' => 'A', 'Ã' => 'A', 'Â' => 'A', 'Ä' => 'A', 'Ç' => 'C', 'É' => 'E', 'È' => 'E', 'Ẽ' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Í' => 'I', 'Ì' => 'I', 'Ĩ' => 'I', 'Î' => 'I', 'Ï' => 'I',
		'Ó' => 'O', 'Ò' => 'O', 'Õ' => 'O', 'Ô' => 'O', 'Ö' => 'O', 'Ú' => 'U', 'Ù' => 'U', 'Ũ' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Ỳ' => 'Y', 'Ŷ' => 'Y',
		'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a', 'ç' => 'c', 'é' => 'e', 'è' => 'e', 'ẽ' => 'e', 'ê' => 'e', 'ë' => 'e', 'í' => 'i', 'ì' => 'i', 'ĩ' => 'i', 'î' => 'i', 'ï' => 'i',
		'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o', 'ú' => 'u', 'ù' => 'u', 'ũ' => 'u', 'û' => 'u', 'ü' => 'u', '\'' => ' '
	);
	$cedente_con = strtr($cedente_con, $acentosParaNaoAcentos);
	$dados["bairro_cli"] = strtr($dados["bairro_cli"], $acentosParaNaoAcentos);
	$dados["endereco_cli"] = strtr($dados["endereco_cli"], $acentosParaNaoAcentos);
	$dados["desc_cid"] = strtr($dados["desc_cid"], $acentosParaNaoAcentos);

	## REGISTRO HEADER de arquivo

	# Quando for numero coloca zeros à esquerda

	# Quando for alfanumérico coloca zeros à direita				

	$conteudo .= $codigo_banco; # Código do Banco na Compensação

	$conteudo .= formata_numdoc(0,4); # Lote de Serviço

	$conteudo .= '0'; # Tipo de Registro

	$conteudo .= complementoRegistro(9,"brancos"); # Uso Exclusivo FEBRABAN / CNAB 

	$conteudo .= 2; # Tipo de Inscrição da Empresa

	$conteudo .= formata_numdoc($cnpj,14); # numero de Inscrição da Empresa (CNPJ)

	$conteudo .= formata_numdoc($convenio,20); # Convênio
	
	$conteudo .= formata_numdoc($agencia,5); # agência

	$conteudo .= formata_numdoc($agencia_digito,1); # dígito agência

	$conteudo .= formata_numdoc($conta,12); # conta corrente

	$conteudo .= formata_numdoc($conta_digito,1); # dígito conta corrente

	$conteudo .= complementoRegistro(1,"brancos"); # Dígito Verificador da Ag/Conta (Analista da CECRED mandou preencher em banco)

	$conteudo .= limit($cedente_con,30); # Nome da Empresa

	$conteudo .= limit('Bradesco',30); # Nome da Cooperativa

	$conteudo .= complementoRegistro(10,"brancos"); # Uso Exclusivo FEBRABAN / CNAB

	$conteudo .= 1; # 1 - remessa   2 - retorno

	$conteudo .= $dia.$mes.$ano; # Data de Geração do Arquivo

	$conteudo .= $hora.$minuto.$segundo; # Hora de Geração do Arquivo

	$conteudo .= formata_numdoc($id_rem,6); # Número Sequencial do Arquivo

	$conteudo .= '084'; # Número da Versão do Layout do Arquivo

	$conteudo .= formata_numdoc(1600,5); # Densidade de Gravação do Arquivo

	$conteudo .= complementoRegistro(20,"brancos"); # Para Uso Reservado da Coop.

	$conteudo .= complementoRegistro(20,"brancos"); # Para Uso Reservado da Empresa (podem ser observaçoes ou algo do gênero)

	$conteudo .= complementoRegistro(29,"brancos"); # Uso Exclusivo FEBRABAN / CNAB

	$conteudo .= chr(13).chr(10); //essa é a quebra de linha


	# Registro header de lote

	$lote = 0;
	$qtdRegistros=1;
	foreach($datasFormatadas as $dataFormatada){
		$lote++;
		$registroNoLote = 1;

		$conteudo .= $codigo_banco; # Codigo do Banco na Compensacao

		$conteudo .= formata_numdoc($lote,4); # Lote de serviço

		$conteudo .= '1'; # Tipo de Registro

		$conteudo .= 'R'; # Tipo de Operacao

		$conteudo .= '01'; # Tipo de Servico
		$conteudo .= complementoRegistro(2,"brancos"); # Uso Exclusivo FEBRABAN / CNAB 

		$conteudo .= '042'; # Numero da Versao do Layout do Lote

		$conteudo .= complementoRegistro(1,"brancos"); # Uso Exclusivo FEBRABAN / CNAB 

		$conteudo .= 2; # Tipo de Inscricao da Empresa

		$conteudo .= formata_numdoc($cnpj,15); # Numero de Inscricao da Empresa (CNPJ)

		$conteudo .= formata_numdoc($convenio,20); # Convenio

		$conteudo .= formata_numdoc($agencia,5); # agencia

		$conteudo .= formata_numdoc($agencia_digito,1); # digito agencia

		$conteudo .= formata_numdoc($conta,12); # conta corrente

		$conteudo .= formata_numdoc($conta_digito,1); # digito conta corrente

		$conteudo .= complementoRegistro(1,"brancos"); # Digito Verificador da Ag/Conta (Analista da CECRED mandou preencher em banco)

		$conteudo .= limit($cedente_con,30); # Nome da Empresa

		$conteudo .= limit('Nao sera cobrado juros ou multa.',40); # Mensagem 1

		$conteudo .= limit('Pagavel em ate 60 dias apos vencimento.',40); # Mensagem 2

		$conteudo .= formata_numdoc($id_rem,8); # Numero Remessa/Retorno

		$conteudo .= $dia.$mes.$ano; # Data de Gravacao Remessa/Retorno

		$conteudo .= formata_numdoc(0,8); # Data do Credito

		$conteudo .= complementoRegistro(33,"brancos"); # Uso Exclusivo FEBRABAN / CNAB 

		$conteudo .= chr(13).chr(10); //essa e a quebra de linha

		$qtdRegistros++;


		############# Aqui voce faz a consulta pra listar todos os registros e gerar remessa para um ou mais boletos



		# Registro Detalhe a Segmento P

		$conteudo .= $codigo_banco; # Codigo do Banco na Compensacao

		$conteudo .= formata_numdoc($lote,4); # Lote de serviço

		$conteudo .= '3'; # Tipo de Registro

		$conteudo .= formata_numdoc($registroNoLote,5); # No Sequencial do Registro no Lote

		$conteudo .= 'P'; # Cod. Segmento do Registro Detalhe

		$conteudo .= complementoRegistro(1,"brancos"); # Uso Exclusivo FEBRABAN / CNAB 

		$conteudo .= '01'; # Codigo de Movimento Remessa

		$conteudo .= formata_numdoc($agencia,5); # agencia

		$conteudo .= formata_numdoc($agencia_digito,1); # digito agencia

		$conteudo .= formata_numdoc($conta,12); # conta corrente

		$conteudo .= formata_numdoc($conta_digito,1); # digito conta corrente

		$conteudo .= complementoRegistro(1,"brancos"); # Digito Verificador da Ag/Conta (Analista da CECRED mandou preencher em banco)

		$conteudo .= formata_numdoc($carteira, 3); # Identificação do produto

		$conteudo .= formata_numdoc(0,5); # Zeros

		$nosso_numero = formata_numdoc($conta.$conta_digito.$dados["id_cob"],11);


		//Cálculo do dígito de verificação do nosso número de acordo com o padrão Bradesco

		$peso = 2;
		$soma = 0;

		// Inverte o número para facilitar o cálculo
		$numeroInvertido = strrev($carteira.$nosso_numero);

		// Loop pelos dígitos do número
		for ($i = 0; $i < strlen($numeroInvertido); $i++) {
			$digito = $numeroInvertido[$i];
			$soma += $digito * $peso;

			// Incrementa o peso
			$peso++;
			if ($peso > 7) {
				$peso = 2;
			}
		}

		$resto = $soma % 11;
		if($resto == 1){
			$digitoVerificador = 'P';
		}
		else if($resto == 0){
			$digitoVerificador = '0';
		}
		else{
			$digitoVerificador = 11 - $resto;
		}
		

		



		$conteudo .= limit($nosso_numero,11); # Numero do Documento de Cobranca (Nosso Número)

		$conteudo .= limit($digitoVerificador, 1); # Dígito verificador do Nosso Número

		$conteudo .= 1; # Código da carteira 

		$conteudo .= 1; # Forma de Cadastr. do Titulo no Banco

		$conteudo .= 1; # Tipo de Documento

		$conteudo .= 1; # Identificacao da Emissao do Boleto

		$conteudo .= 1; # Identificacao da Distribuicao		

		$conteudo .= limit($dados["id_cob"],15); # numero do Documento de Cobranca

		$conteudo .= $dataFormatada; # Data vencimento

		$conteudo .= formata_numdoc(number_format($valor,2,'',''),15); # Valor Nominal do Titulo

		$conteudo .= formata_numdoc(0,5); # Agencia Encarregada da Cobranca

		$conteudo .= formata_numdoc(0,1); # Digito Verificador da Agencia

		$conteudo .= '32'; # Especie do Titulo

		$conteudo .= 'A'; # Identific. de Titulo Aceito/Nao Aceito

		$conteudo .= formata_numdoc($dia.$mes.$ano,8); # Data da Emissao/Documento do Titulo

		$conteudo .= 3; # Codigo do Juros de Mora

		$conteudo .= formata_numdoc(0,8); # Data do Juros de Mora

		$conteudo .= formata_numdoc(0,15); # Juros de Mora por Dia/Taxa

		$conteudo .= 0; # Codigo do Desconto 1

		$conteudo .= formata_numdoc(0,8); # Data do desconto

		$conteudo .= formata_numdoc(0,15); # Valor/Percentual a ser Concedido

		$conteudo .= formata_numdoc(0,15); # Valor do IOF a ser Recolhido

		$conteudo .= formata_numdoc(0,15); # Valor do Abatimento

		$conteudo .= limit($dados["id_cob"],25); # Identificacao do Titulo na Empresa

		$conteudo .= 3; # Codigo para Negativacao via Serasa (protestar ou Nao)

		$conteudo .= formata_numdoc(0,2); # numero de Dias para Negativacao

		$conteudo .= 2; # Codigo para Baixa/Devolucao

		$conteudo .= complementoRegistro(3,"brancos"); # numero de Dias para Baixa/Devolucao

		$conteudo .= '09'; # Codigo da Moeda

		$conteudo .= formata_numdoc(0,10); # No do Contrato da Operacao de Cred.

		$conteudo .= complementoRegistro(1,"brancos"); # Uso livre banco/empresa ou autorizacao de pagamento parcial

		$conteudo .= chr(13).chr(10); //essa e a quebra de linha

		$qtdRegistros++;



		# Registro Detalhe a Segmento Q

		$registroNoLote++;

		$conteudo .= $codigo_banco; # Codigo do Banco na Compensacao

		$conteudo .= formata_numdoc($lote,4); # Lote de serviço

		$conteudo .= '3'; # Tipo de Registro

		$conteudo .= formata_numdoc($registroNoLote,5); # No Sequencial do Registro no Lote

		$conteudo .= 'Q'; # Cod. Segmento do Registro Detalhe

		$conteudo .= complementoRegistro(1,"brancos"); # Uso Exclusivo FEBRABAN / CNAB 

		$conteudo .= '01'; # Codigo de Movimento Remessa

		# dados do sacado

		$conteudo .= $tipo_inscricao; # Tipo de Inscricao da Empresa



		$documento_cliente = str_replace('.','',$dados["documento_cliente"]);

		$documento_cliente = str_replace('-','',$documento_cliente);

		$documento_cliente = str_replace('/','',$documento_cliente);



		$conteudo .= formata_numdoc($documento_cliente,15); # numero de Inscricao

		$conteudo .= limit($nome,40); # Nome cliente

		$conteudo .= limit($dados["endereco_cli"],40); # Endereco cliente

		$conteudo .= limit($dados["bairro_cli"],15); # Bairro cliente

		$conteudo .= limit(substr($dados["cep_cli"],0,5),5); # cep cliente

		$conteudo .= limit(substr($dados["cep_cli"],-3),3); # sufixo cep cliente

		$conteudo .= limit($dados["desc_cid"],15); # Cidade cliente

		$conteudo .= limit($dados["desc_est"],2); # UF cliente

		# dados do sacado/avalista

		$conteudo .= formata_numdoc(0,1); # Tipo de Inscricao do avalista

		$conteudo .= formata_numdoc(0,15); # numero de Inscricao avalista

		$conteudo .= limit('',40); # Nome avalista



		$conteudo .= formata_numdoc(0,3); # Cod. Bco. Corresp. na Compensacao

		$conteudo .= limit('',20); # Nosso No no Banco Correspondente

		$conteudo .= complementoRegistro(8,"brancos"); # Uso Exclusivo FEBRABAN / CNAB 								

		$conteudo .= chr(13).chr(10); //essa e a quebra de linha

		$qtdRegistros++;
		$registroNoLote++;
		$registroNoLote++;
		# Registro Trailer de lote
		$conteudo .= $codigo_banco; # Codigo do Banco na Compensacao
		$conteudo .= formata_numdoc($lote, 4); # Lote de serviço
		$conteudo .= "5"; # Tipo de registro 
		$conteudo .= complementoRegistro(9,"brancos"); # Uso Exclusivo FEBRABAN / CNAB 
		$conteudo .= formata_numdoc($registroNoLote,6); # Quantidade de registros no lote
		# Totalização da cobrança simples
		$conteudo .= formata_numdoc($lote, 6); # Quantidade de títulos em cobrança
		$conteudo .= formata_numdoc(number_format($dados["valor_cob"],2,'',''),17); # Valor total dos títulos em carteira
		# Totalização da cobrança vinculada
		$conteudo .= formata_numdoc($lote, 6); # Quantidade de títulos em cobrança
		$conteudo .= formata_numdoc(number_format($dados["valor_cob"],2,'',''),17); # Valor total dos títulos em carteira
		# Totalização da cobrança caucionada
		$conteudo .= formata_numdoc($lote, 6); # Quantidade de títulos em cobrança
		$conteudo .= formata_numdoc(number_format($dados["valor_cob"],2,'',''),17); # Valor total dos títulos em carteira
		# Totalização da cobrança descontada
		$conteudo .= formata_numdoc($lote, 6); # Quantidade de títulos em cobrança
		$conteudo .= formata_numdoc(number_format($dados["valor_cob"],2,'',''),17); # Valor total dos títulos em carteira
		$conteudo .= formata_numdoc($id, 8); # Numero do aviso de lançamento
		$conteudo .= complementoRegistro(117,"brancos"); # Uso Exclusivo FEBRABAN / CNAB 
		$conteudo .= chr(13).chr(10);
		$qtdRegistros++;
	}
	############# Aqui termmina sua consulta pra listar todos os registros e gerar remessa para um ou mais boletos





	# Registro Trailer de arquivo

	$qtdRegistros++;

	$conteudo .= $codigo_banco; # Codigo do Banco na Compensacao

	$conteudo .= 9999; # Lote de serviço

	$conteudo .= 9; # Tipo de Registro

	$conteudo .= complementoRegistro(9,"brancos");

	$conteudo .= formata_numdoc($lote,6); # Quantidade de Lotes do Arquivo

	$conteudo .= formata_numdoc($qtdRegistros,6); # Quantidade de Registros do Arquivo

	$conteudo .= formata_numdoc(0,6); # Qtde de Contas p/ Conc. (Lotes)

	$conteudo .= complementoRegistro(205,"brancos");

	$conteudo .= chr(13).chr(10); //essa e a quebra de linha


	
	
	
	if (!$handle = fopen($filename, 'w+')) 
		{
			echo "Nao foi possível abrir o arquivo ($filename)";
		}

	// Escreve $conteudo no nosso arquivo aberto.

	if(fwrite($handle, "$conteudo") === FALSE) 

		{
			echo "Nao foi possível escrever no arquivo ($filename)";
		}

	fclose($handle);
	
	
	$obj = [
		'codigo'=>$codigo,
		'dataVencimentoIni'=>$dataVencimento[0],
		'dataVencimentoFin'=>end($dataVencimento),
		'dataAtual'=>$ano.$mes.$dia,
		'valor'=>$valor,
		'qtdBoletos'=>$lote,
		"filename"=>$nomeParaDownload,
	];
	$obj = json_encode($obj);
	echo $obj;

?>