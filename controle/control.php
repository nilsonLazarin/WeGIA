<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
session_start();

function processaRequisicao($nomeClasse, $metodo, $modulo = null){
	if ($nomeClasse && $metodo) {
        if ($modulo) {
            include_once $modulo . "/" . $nomeClasse . ".php";
        } else {
            include_once $nomeClasse . ".php";
        }

		if(!isset($_SESSION['id_pessoa'])){
			http_response_code(401);
			exit('Operação negada: Cliente não autorizado');
		}

        // Cria uma instância da classe e chama o método
        $objeto = new $nomeClasse();
        $objeto->$metodo();
    } else {
        // Responde com erro se as variáveis necessárias não foram fornecidas
        http_response_code(400);
        exit('Classe ou método não fornecidos: '.'C = '.$nomeClasse.'M = '.$metodo);
    }
}

if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !==false) {
	// Recebe o JSON da requisição
	$json = file_get_contents('php://input');
	// Decodifica o JSON
	$data = json_decode($json, true);

	// Extrai as variáveis do array $data
	$nomeClasse = $data['nomeClasse'] ?? null;
	$metodo = $data['metodo'] ?? null;
	$modulo = $data['modulo'] ?? null;

	// Processa a requisição
	processaRequisicao($nomeClasse, $metodo, $modulo);
} else {
	// Recebe os dados do formulário normalmente
	$nomeClasse = $_REQUEST['nomeClasse'] ?? null;
	$metodo = $_REQUEST['metodo'] ?? null;
	$modulo = $_REQUEST['modulo'] ?? null;

	// Processa a requisição
	processaRequisicao($nomeClasse, $metodo, $modulo);
}