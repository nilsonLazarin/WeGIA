<?php

	//Simplifica a implementação de mensagens
	/**
	 * 	Modo de uso:
	 * 
	 * 		getMSG( Nome da mensagem (OPCIONAL)(DEFAULT = 'msg') , Nome da flag (OPCIONAL)(DEFAULT = 'flag') ):
	 * 			usa a estrutura:
	 * 				$_GET[ Nome da mensagem ]: Mensagem a ser exibida
	 * 				$_GET[ Nome da flag ]: Valor que indica o tipo de mensagem (sucesso, erro ou aviso)
	 * 
	 * 		displayMsg():
	 * 			usa a estrutura: 
	 * 				$_GET['msg']: diz o tipo de mensagem - sucesso, erro..., 
	 * 				$_GET['sccs'/'warn'/'err']: contém a mensagem para cada caso (OPCIONAL)
	 * 				$_GET['log']: contém log de códigos (fica dentro de uma tag <PRE>, portanto exibe quebra de linhas por \n) (OPCIONAL)
	 * 
	 */

    function displaySuccess($sccs = "Operação realizada com sucesso!", $log = null){
		$pre = "";
		if ($log){
			$pre .= "<pre>$log</pre>";
		}
		echo("
			<div class='alert alert-success'>
				<i class='fas fa-check mr-md'></i>
				<a href='#' class='close' onclick='closeMsg()' data-dismiss='alert' aria-label='close'>
					&times;
				</a>
				$sccs
				$pre
			</div>"
		);
	}

	function displayWarning($warn = "Houve um problema ao realizar a operação", $log = null){
		$pre = "";
		if ($log){
			$pre .= "<pre>$log</pre>";
		}
		echo("
			<div class='alert alert-warning'>
			<i class='fas fa-exclamation-triangle'></i>
				<a href='#' class='close' onclick='closeMsg()' data-dismiss='alert' aria-label='close'>
					&times;
				</a>
				$warn
				$pre
			</div>"
		);
	}

	function displayError($error = "Houve um erro ao realizar a operação", $log = null){
		$pre = "";
		if ($log){
			$pre .= "<pre>$log</pre>";
		}
		echo("
			<div class='alert alert-danger'>
				<i class='fas fa-times-circle'></i>
				<a href='#' class='close' onclick='closeMsg()' data-dismiss='alert' aria-label='close'>
					&times;
				</a>
				$error
				$pre
			</div>"
		);
	}

	function displayMsg($msgName = 'msg'){
		if (isset($_GET[$msgName])){
			$msg = $_GET[$msgName];
			$log = null;
			if (isset($_GET['log'])){
				$log = base64_decode($_GET['log']);
			}
			
			if ($msg == "success"){
				$sccs = $_GET['sccs'] ?? null;
				if ($sccs && $log){
					displaySuccess($sccs, $log);
				}else if ($sccs){
					displaySuccess($sccs);
				}else{
					displaySuccess();
				}
			}
			
			if ($msg == "wanring"){
				$warn = $_GET['warn'] ?? null;
				if ($warn && $log){
					displayWarning($warn, $log);
				}else if ($warn){
					displayWarning($warn);
				}else{
					displayWarning();
				}
			}
			
			if ($msg == "error"){
				$err = $_GET['err'] ?? null;
				if ($err && $log){
					displayError($err, $log);
				}else if ($err){
					displayError($err);
				}else{
					displayError();
				}
			}
		}
	}
	
	function getMsg($getName = 'msg', $flagName = 'flag'){

		/**
		 * Flags:
		 * 
		 * 'sccs': Exibe uma mensagem de sucesso
		 * 'warn': Exibe uma mensagem de atenção
		 * 'err': Exibe uma mensagem de erro
		 * 
		 */

		if (isset($_GET[$getName])){
			$flag = $_GET[$flagName] ?? null;
			$msg = $_GET[$getName];
			$log = $_GET['log'] ?? null;
			if ($log){
				switch ($flag){
					default:
					case "sccs":
					case "success":
					case "sucesso":
						displaySuccess($msg, $log);
					break;
					case "warn":
					case "warning":
					case "aviso":
						displayWarning($msg, $log);
					break;
					case "err":
					case "error":
					case "erro":
						displayError($msg, $log);
					break;
				}
			}else{
				switch ($flag){
					case "sccs":
					case "success":
					case "sucesso":
						displaySuccess($msg);
					break;
					case "warn":
					case "warning":
					case "aviso":
						displayWarning($msg);
					break;
					case "err":
					case "error":
					case "erro":
						displayError($msg);
					break;
				}
			}
		}
	}
    
?>