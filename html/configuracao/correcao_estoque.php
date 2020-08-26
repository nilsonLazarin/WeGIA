<?php
    session_start();
    if (!isset($_SESSION['usuario'])){
        header("Location: ../../index.php");
	}
	
	// Verifica Permissão do Usuário
	require_once '../permissao/permissao.php';
	permissao($_SESSION['id_pessoa'], 9, 1);

	require_once '../../dao/Conexao.php';
	
	function last_key($array){
		return array_search(end($array), $array);
	}

	function corrige_estoque(){
		$somaEntrada = [];
		$somaSaida = [];
		$somaTotal = [];
		$result = "success";
		$log = '';
		$pdo = Conexao::connect();
		try{
			// Quantidade de itens na entrada
			$ientrada = $pdo->query("
			SELECT ie.id_produto, ie.qtd, e.id_almoxarifado 
			FROM ientrada ie 
			INNER JOIN entrada e ON e.id_entrada = ie.id_entrada 
			GROUP BY CONCAT(ie.id_produto, e.id_almoxarifado) 
			ORDER BY ie.id_produto;
			")->fetchAll(PDO::FETCH_ASSOC);
			foreach ($ientrada as $key => $item){
				extract($item);
				if (isset($somaEntrada[$id_produto][$id_almoxarifado])){
					$somaEntrada[$id_produto][$id_almoxarifado] += floatval($qtd);
				}else{
					$somaEntrada[$id_produto][$id_almoxarifado] = floatval($qtd);
				}
			}
			// Quantidade de itens na saida
			$isaida = $pdo->query("
			SELECT isa.id_produto, isa.qtd, s.id_almoxarifado 
			FROM isaida isa 
			INNER JOIN saida s ON s.id_saida = isa.id_saida 
			GROUP BY CONCAT(isa.id_produto, s.id_almoxarifado) 
			ORDER BY isa.id_produto;
			")->fetchAll(PDO::FETCH_ASSOC);
			foreach ($isaida as $key => $item){
				extract($item);
				if (isset($somaSaida[$id_produto][$id_almoxarifado])){
					$somaSaida[$id_produto][$id_almoxarifado] += floatval($qtd);
				}else{
					$somaSaida[$id_produto][$id_almoxarifado] = floatval($qtd);
				}
			}
			// Guarda a quantidade entrada - quantidade saida
			$cont = (last_key($somaEntrada) >= last_key($somaSaida) ? last_key($somaEntrada) : last_key($somaSaida));
			for ($id = 0; $id <= $cont; $id++){
				
				if (isset($somaEntrada[$id]) || isset($somaSaida[$id])){
					foreach ($somaEntrada[$id] as $id_almox => $qtd){
						$qtdEntrada = (isset($somaEntrada[$id][$id_almox]) ? $somaEntrada[$id][$id_almox] : 0);
						$qtdSaida = (isset($somaSaida[$id][$id_almox]) ? $somaSaida[$id][$id_almox] : 0);
						$somaTotal[$id][$id_almox] = $qtdEntrada - $qtdSaida;
					}
				}
			}

			// Debug
			// var_dump($somaEntrada, $somaSaida, $somaTotal);


			$changed = 0;
			$added = 0;
			$warns = 0;
			foreach ($somaTotal as $id => $val){
				// Percorre as linhas
				foreach ($val as $almox => $qtd){
					// Percorre as colunas

					$estoque = $pdo->query("SELECT qtd FROM estoque WHERE id_produto=$id AND id_almoxarifado=$almox")->fetch(PDO::FETCH_ASSOC);
					$desc = $pdo->query("SELECT descricao, codigo, oculto FROM produto WHERE id_produto=$id;")->fetch(PDO::FETCH_ASSOC);
					$almoxarifado = $pdo->query("SELECT descricao_almoxarifado FROM almoxarifado WHERE id_almoxarifado=$almox;")->fetch(PDO::FETCH_ASSOC);

					if ($desc && $almoxarifado){
						// Caso o produto e o almoxarifado estejam cadastrados
						extract($desc);
						extract($almoxarifado);
						if ($estoque){
							// Caso o produto esteja em estoque
							$qtd_atual = $estoque['qtd'];
							if ($qtd_atual != $qtd){
								// Se a quantidade em estoque não bater com a entrada e a saida
								$dif = $qtd - $qtd_atual;
								$changed += $pdo->exec("UPDATE estoque SET qtd=$qtd WHERE id_produto=$id AND id_almoxarifado=$almox;");
								$log .= abs($dif)." itens ($descricao | $codigo ".($oculto ? "[Oculto]" : "" ).") ".($dif > 0 ? "adicionados no" : "retirados do")." almoxarifado $descricao_almoxarifado.\n";
							}else{
								// Caso a quantidade dos registros existentes esteja certa
								if ($qtd < 0){
									// Caso a quantidade dos registros existentes esteja certa e seja negativa
									$warns ++;
									$log .= "AVISO: $descricao | $codigo ".($oculto ? "[Oculto]" : "" )." possui estoque negativo no almoxarifado $descricao_almoxarifado\n";
								}
							}
						}else{
							// Caso o produto não esteja em estoque
							$added += $pdo->exec("INSERT INTO estoque (id_produto, id_almoxarifado, qtd) VALUES ( $id , $almox , $qtd );");
							if ($qtd < 0){
								// Caso a quantidade seja negativa
								$log .= "Registro criado: $descricao | $codigo ".($oculto ? "[Oculto]" : "" )." possui ".$somaSaida[$id][$almox]." saídas e ".$somaEntrada[$id][$almox]." entradas. O estoque está negativo ($qtd).\n";
								$result = "warning";
								$warns++;
							}else{
								$log .= "Registro criado: $descricao | $codigo ".($oculto ? "[Oculto]" : "" ).". $qtd unidades adicionadas no almoxarifado $descricao_almoxarifado.\n";
							}
						}
					}else{
						// Caso o produto e o almoxarifado não estejam cadastrados
						$result='warning';
						$warns ++;
						// $warns += intval(!$desc) + intval(!$almoxarifado);
						$log .= "ATENÇÂO: Existem $qtd itens (".$somaEntrada[$id][$almox]." entradas, ".$somaSaida[$id][$almox]." saidas)".(!$desc ? " associados a um produto não cadastrado de ID $id" : '').(!$almoxarifado ? " armazenados em um almoxarifado não cadastrado de ID $almox" : '')."\n";
					}






					// if ($qtd < 0) {
					// 	// Caso a quantidade seja negativa
					// 	$prod = $pdo->query("SELECT qtd FROM estoque WHERE id_produto=$id AND id_almoxarifado=$almox;")->fetch(PDO::FETCH_ASSOC);
					// 	$desc = $pdo->query("SELECT descricao, codigo, oculto FROM produto WHERE id_produto=$id;")->fetch(PDO::FETCH_ASSOC);
					// 	extract($desc);
					// 	if ($prod["qtd"] == $qtd){
					// 		// Caso A quantidade já esteja certa
					// 		$log .= "ATENÇÃO: $descricao | $codigo ".($oculto ? "[Oculto] " : "" )."possui ".$somaSaida[$id][$almox]." saídas e ".$somaEntrada[$id][$almox]." entradas. O estoque está negativo ($qtd).\n";
					// 		$result = "warning";
					// 		$warns++;
					// 		continue;
					// 	}
					// 	// Caso a quantidade
					// 	$pdo->exec("UPDATE estoque SET qtd=$qtd WHERE id_produto=$id AND id_almoxarifado=$almox");
					// 	$log .= "$descricao | $codigo ".($oculto ? "[Oculto] " : "" )."possui ".$somaSaida[$id][$almox]." saídas e ".$somaEntrada[$id][$almox]." entradas. O estoque está negativo ($qtd).\n";
					// 	$changed++;
					// 	continue;
					// }
					// if ($estoque){
					// 	if ($qtd != $estoque['qtd']){
					// 		$pdo->exec("UPDATE estoque SET qtd=$qtd WHERE id_produto=$id AND id_almoxarifado=$almox");
					// 		$changed++;
					// 	}
					// }else{
					// 	$pdo->exec("INSERT INTO estoque (id_produto, id_almoxarifado, qtd) VALUES ( $id , $almox , $qtd );");
					// 	$added++;
					// }
				}
			}
			$estoque = $pdo->query("SELECT * FROM estoque;")->fetchAll(PDO::FETCH_ASSOC);
			foreach ($estoque as $key => $item){
				// Para cada item em estoque
				if (!isset($somaEntrada[$item['id_produto']][$item['id_almoxarifado']]) && !isset($somaEntrada[$item['id_produto']][$item['id_almoxarifado']]) && $item['qtd'] != 0){
					// Verifica se há registros de entrada nem saida para o produto e zera caso não esteja
					$desc = $pdo->query("SELECT descricao, codigo, oculto FROM produto WHERE id_produto=".$item['id_produto'])->fetch(PDO::FETCH_ASSOC);
					extract($desc);
					$log .= "AVISO: ".$item['id_produto']." | $descricao | $codigo ".($oculto ? "[Oculto] " : "" )."continha ".$item['qtd']." itens sem registro de entrada e saida e seu estoque foi zerado.\n";
					$warns++;
					$pdo->exec("UPDATE estoque SET qtd=0 WHERE id_produto=".$item['id_produto']." AND id_almoxarifado=".$item['id_almoxarifado']);
					$result = "warning";
					$changed++;
				}
			}
			$log = "$changed Linhas Alteradas\n$added Linhas Adicionadas\n$warns Avisos\n\n" . (($changed + $added) == 0 ? "Não houveram alterações no Banco de Dados\n" : "") . $log;
		}catch (Exeption $e){
			$result = "error";
			$log = "Erro: \n$e";
		}
		return [$result, $log];
	}

	function success(){
		header("Location: ./atualizacao_sistema.php?tipo=success&mensagem=Varredura realizada com sucesso!");
	}
	
	function warning(){
		header("Location: ./atualizacao_sistema.php?tipo=warning&mensagem=Varredura realizada com sucesso! Exceção:");
	}
	
	function error(){
		header("Location: ./atualizacao_sistema.php?tipo=error&mensagem=Houve um erro ao executar a varredura:");
	}
	
	$result = corrige_estoque();
	$log = $result[1];
	$_SESSION['log']=$log;


	// Debug
	// var_dump($result);
	// die();

	switch ($result[0]){
		case "warning":
			warning();
		break;
		case "success":
			success();
		break;
		case "error":
		default:
			error();
	}
?>