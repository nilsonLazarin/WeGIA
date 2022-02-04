<?php
	
	date_default_timezone_set("America/Sao_Paulo");

	require_once '../dao/Conexao.php';
	require_once '../Functions/funcoes.php';
	require_once './seguranca/sessionStart.php';

	if($_SERVER['REQUEST_METHOD']=="POST"){
			session_start();
			extract($_REQUEST);
			//$cpf=str_replace(".", '', $cpf);
   			//$cpf=str_replace("-", "", $cpf);
   			
			$pdo = Conexao::connect();
			$consulta = $pdo->query('SELECT id_pessoa, cpf, senha, nome, adm_configurado, nivel_acesso from pessoa');
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
					// Ultima release disponível
					$last_release = intval(file_get_contents("https://www.wegia.org/software/release"));
					// Release instalada
					$local_release = intval(file_get_contents("../.release"));

					if ($local_release < $last_release){
						require "./geral/msg.php";
						setSessionMsg("O sistema possui atualizações disponíveis", "warn");
					}

					$_SESSION['local_release'] = gmdate('d/m/Y, h:m:i', intval(file_get_contents("../.release")));
					header ("Location: ../html/home.php");
				}
				else{
					$_SESSION['usuario'] = $cpf;
					$_SESSION['id_pessoa'] = $id_pessoa;
					if($linha['adm_configurado'] == 0 && $linha['cpf'] == "admin" && $linha['nivel_acesso'] == 2){
						header("Location: ../html/alterar_senha.php");

					}else {
						// Ultima release disponível
						$last_release = intval(file_get_contents("https://www.wegia.org/software/release"));
						// Release instalada
						$local_release = intval(file_get_contents("../.release"));

						$outdated = "";

						if ($local_release < $last_release){
							require "./geral/msg.php";
							setSessionMsg("O sistema possui atualizações disponíveis", "warn");
							$outdated = " (desatualizado)";
						}
						setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
						date_default_timezone_set('America/Sao_Paulo');
						$_SESSION['local_release'] = strftime('%A, %d de %B de %Y, às %H:%M', intval(file_get_contents("../.release"))) . $outdated;
						header("Location: ../html/home.php");
					}
				}
			}
			else{
				header ("Location: ../index.php?erro=erro");
			}

	}
	
?>