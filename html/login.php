<?php
	
	date_default_timezone_set("America/Sao_Paulo");

	require_once '../dao/Conexao.php';
	require_once '../Functions/funcoes.php';

	if($_SERVER['REQUEST_METHOD']=="POST"){
			session_start();
			extract($_REQUEST);
			$cpf=str_replace(".", '', $cpf);
   			$cpf=str_replace("-", "", $cpf);
   			
			$pdo = Conexao::connect();
			$consulta = $pdo->query('SELECT id_pessoa, cpf, senha, nome from pessoa');
			$pwd=hash('sha256', $pwd);
			while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
				if($linha["cpf"] == $cpf && $linha["senha"] == $pwd){
					$c = "true";
					$id_pessoa=$linha["id_pessoa"];
					$nome = $linha["nome"];
					break;
				}
			}
			if($c == "true"){
				if(isset($_SESSION['usuario'])){
					session_destroy();
					session_start();
					$_SESSION['usuario'] = $cpf;
					$_SESSION['id_pessoa'] = $id_pessoa;
					$_SESSION['time']=time()+(30);
					header ("Location: ../html/home.php");
				}
				else{
					$_SESSION['usuario'] = $cpf;
					$_SESSION['id_pessoa'] = $id_pessoa;
					header ("Location: ../html/home.php");
				}
			}
			else{
				header ("Location: ../index.php?erro=erro");
			}

	}
	
?>