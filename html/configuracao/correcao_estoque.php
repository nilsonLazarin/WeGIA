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
			var_dump($somaEntrada, $somaSaida, $somaTotal);
			$changed = 0;
			$added = 0;
			foreach ($somaTotal as $id => $val){
				foreach ($val as $almox => $qtd){
					// echo("<br>$id $almox $qtd ");
					if ($qtd < 0) {
						$desc = $pdo->query("SELECT descricao, codigo, oculto FROM produto WHERE id_produto=$id;")->fetch(PDO::FETCH_ASSOC);
						$pdo->exec("UPDATE estoque SET qtd=0 WHERE id_produto=$id");
						extract($desc);
						$log .= "$descricao | $codigo ".($oculto ? "[Oculto] " : "" )."possui ".$somaSaida[$id][$almox]." saídas e ".$somaEntrada[$id][$almox]." entradas. Sua quantidade foi zerada.\n";
						$result = "warning";
						$changed++;
						// echo("Odd ");
						continue;
					}
					$estoque = $pdo->query("SELECT * FROM estoque WHERE id_produto=$id AND id_almoxarifado=$almox")->fetch(PDO::FETCH_ASSOC);
					if ($estoque){
						if ($qtd != $estoque['qtd']){
							$pdo->exec("UPDATE estoque SET qtd=$qtd WHERE id_produto=$id AND id_almoxarifado=$almox");
							$changed++;
							// echo("Atual: ".$estoque['qtd']." ");
						}
					}else{
						$pdo->exec("INSERT INTO estoque (id_produto, id_almoxarifado, qtd) VALUES ( $id , $almox , $qtd);");
						$added++;
					}
				}
			}
			$estoque = $pdo->query("SELECT * FROM estoque;")->fetchAll(PDO::FETCH_ASSOC);
			foreach ($estoque as $key => $item){
				if (!isset($somaEntrada[$item['id_produto']][$item['id_almoxarifado']]) && $item['qtd'] != 0){
					$desc = $pdo->query("SELECT descricao, codigo, oculto FROM produto WHERE id_produto=".$item['id_produto'])->fetch(PDO::FETCH_ASSOC);
					extract($desc);
					$log .= $item['id_produto']." | $descricao | $codigo ".($oculto ? "[Oculto] " : "" )."continha ".$item['qtd']." itens sem registro de entrada.\n";
					$pdo->exec("UPDATE estoque SET qtd=0 WHERE id_produto=".$item['id_produto']." AND id_almoxarifado=".$item['id_almoxarifado']);
					$result = "warning";
					$changed++;
				}
			}
			$log = "$changed Linhas Alteradas\n$added Linhas Adicionadas\n\n" . $log;
		}catch (Exeption $e){
			$result = "error";
			$log = "Erro: \n$e";
		}
		return [$result, $log];
	}

	function success($log){
		header("Location: ./atualizacao_sistema.php?msg=success&sccs=Varredura realizada com sucesso!&log=".base64_encode($log));
	}
	
	function warning($log){
		header("Location: ./atualizacao_sistema.php?msg=warning&warn=Varredura realizada com sucesso! Exceção:&log=".base64_encode($log));
	}
	
	function error($log){
		header("Location: ./atualizacao_sistema.php?msg=error&err=Houve um erro ao executar a varredura:&log=".base64_encode($log));
	}
	
	$result = corrige_estoque();
	$log = $result[1];

	var_dump($result);
	die();

	switch ($result[0]){
		case "warning":
			warning($log);
		break;
		case "success":
			success($log);
		break;
		case "error":
		default:
			error($log);
	}
?>