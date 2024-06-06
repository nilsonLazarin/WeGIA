<?php
	require("../conexao.php");
	if(!$conexao) header("Location: ../erros/bd_erro/");
	session_start();
	if(isset($_SESSION['adm_configurado'])){
		if($_SESSION['adm_configurado'] == false){
			$titulo = "Configuração Inicial - SaGa";
			$nome = "";
			$foto = "";
			$mensagem = "";
			$senha = "";
			$aviso_img = '<div class="alert alert-info" role="alert">Se deseja manter a imagem predefinida pelo sistema, ignore este campo.</div>';
			$mostrar_botoes = false;
		} 
		else{
			$titulo = "Configurações básicas";
			$id = 1;
			$sql = "select * from configuracao where id=?";
			$stmt = $conexao->prepare($sql);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$dados_config = $result->fetch_assoc();
			$nome = filter_var($dados_config['nome'], FILTER_SANITIZE_STRING);
			$foto = $dados_config['foto_login'];
			$mensagem = filter_var($dados_config['mensagem_login'], FILTER_SANITIZE_STRING);
			$usuario = "admin";
			$sql2 = "select *, AES_DECRYPT(senha, 'token') as senha_d from usuario where usuario=?";
			$stmt2 = $conexao->prepare($sql2);
			$stmt2->bind_param("s", $usuario);
			$stmt2->execute();
			$result2 = $stmt2->get_result();
			$dados_admin = $result2->fetch_assoc();
			$senha = $dados_admin['senha_d'];
			$aviso_img = '<div class="alert alert-info" role="alert">Se deseja manter a imagem atual, ignore este campo.</div>';
			$mostrar_botoes = true;
		} 	
	}else header("Location: ../erros/login_erro");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Primeira configuração - SaGA</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/noui/nouislider.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" action="processa_config.php" method="POST" enctype="multipart/form-data">
				<span class="contact100-form-title">
					<?php echo htmlspecialchars($titulo); ?>
				</span>
				<div class="alert alert-light text-center wrap-input100" role="alert">
					Só é possível criar uma conta de administrador, então escolha uma senha forte!<br>
					Para usar sua conta de <b>administrador</b> você deve usar o usuário 'admin' e sua senha criada.
				</div>
				<div class="wrap-input100 validate-input bg1" data-validate="Digite o nome da empresa!">
					<span class="label-input100">Nome da empresa</span>
					<input class="input100" type="text" name="nome" placeholder="Nome da empresa/instituição" value="<?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');?>">
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Digite sua senha!">
					<span class="label-input100">Senha</span>
					<input class="input100" type="password" name="senha" placeholder="Crie uma senha" value="<?php echo isset($_POST['senha']) ? htmlspecialchars($_POST['senha']) : ''; ?>">
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Digite sua confirmação de senha!" >
					<span class="label-input100">Confirmação</span>
					<input class="input100" type="password" name="c_senha" placeholder="Confirme sua senha" value="<?php echo isset($_POST['senha']) ? htmlspecialchars($_POST['senha']) : ''; ?>">
				</div>

				<div class="wrap-input100 input100-select bg1 rs1-wrap-input100">
					<span class="label-input100">Foto da tela de login</span>
					<input type="file" name="foto_login" class="input100" value="<?php echo($foto); ?>">
					<?php echo($aviso_img); ?>
				</div>

				<div class="wrap-input100 input100-select bg1 rs1-wrap-input100">
					<img class="img-fluid" src="./images/foto-login.png" alt="">
				</div>

				<!-- <div class="wrap-input100 validate-input bg1" data-validate="Digite o nome da empresa!">
					<span class="label-input100">Tema</span>
					<select class="form-control bg1" id="exampleFormControlSelect1">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
    				</select>
				</div> -->
				

				<div class="wrap-input100 validate-input bg0 rs1-alert-validate" data-validate = "Por favor, digite a mensagem.">
					<span class="label-input100">Mensagem da tela de login (você pode usar tags html)</span>
					<textarea class="input100" name="mensagem" placeholder="Escreva a Mensagem desejada..." ><?php echo($mensagem); ?></textarea>
				</div>

				<div class="container-contact100-form-btn">
					<button id="btnConfirma" class="contact100-form-btn">
						<span>
							Confirmar
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
					<?php
						if($mostrar_botoes){
					?>
					<a href="../sair.php" class="badge badge-danger mt-2">Finalizar sessão</a>
					<a href="./reseta_config.php" class="badge badge-primary mt-2">Resetar configurações</a>
					<?php
						}
					?>
				</div>
			</form>
		</div>
	</div>
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!-- Script de envio dos dados -->
	

	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});


			$(".js-select2").each(function(){
				$(this).on('select2:close', function (e){
					if($(this).val() == "Please chooses") {
						$('.js-show-service').slideUp();
					}
					else {
						$('.js-show-service').slideUp();
						$('.js-show-service').slideDown();
					}
				});
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="vendor/noui/nouislider.min.js"></script>
	<script>
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 1500, 3900 ],
	        connect: true,
	        range: {
	            'min': 1500,
	            'max': 7500
	        }
	    });

	    var skipValues = [
	    document.getElementById('value-lower'),
	    document.getElementById('value-upper')
	    ];

	    filterBar.noUiSlider.on('update', function( values, handle ) {
	        skipValues[handle].innerHTML = Math.round(values[handle]);
	        $('.contact100-form-range-value input[name="from-value"]').val($('#value-lower').html());
	        $('.contact100-form-range-value input[name="to-value"]').val($('#value-upper').html());
	    });
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>


</body>
</html>
