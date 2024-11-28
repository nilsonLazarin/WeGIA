<?php
//Sanitizes the request parameters
$controller = trim(htmlspecialchars($_REQUEST['nomeClasse']));
$function = trim(htmlspecialchars($_REQUEST['metodo']));

try {
    if (!$controller || !$function) {
        throw new InvalidArgumentException('Operação Inválida, controladora e função não definidas');
    }

    $whiteList = 
    [
        'exibirBoletosPorCpf',
        'buscarPorDocumento',
        'criarSocio',
    ];

    //Blocks execution for unauthorized access
    if(($controller !='ContribuicaoLogController' && !in_array($function, $whiteList)) || $function == 'pagarPorId'){
        session_start();
        if(!isset($_SESSION['id_pessoa'])){
            throw new Exception('Violação de acesso: '.$function);
        }

        require_once '../../permissao/permissao.php';
        permissao($_SESSION['id_pessoa'], 9, 3);
    }

    $controllerPath = $controller . '.php'; //Prepare the require path

    if (!file_exists($controllerPath)) {
        throw new InvalidArgumentException('Operação Inválida, arquivo da controladora inexistente');
    }

    require_once($controllerPath);

    if (!class_exists($controller)) {
        throw new InvalidArgumentException('Operação Inválida, controladora inexistente');
    }

    $controllerObject = new $controller(); //Instance the controller type object

    if (!method_exists($controllerObject, $function)) {
        throw new InvalidArgumentException('Operação Inválida, método inexistente');
    }

    $controllerObject->$function(); //Calls the controller function
} catch (Exception $e) {
    http_response_code(400);
    exit("Erro: {$e->getMessage()}");
}