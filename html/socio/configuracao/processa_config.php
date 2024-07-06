<?php
    require("../conexao.php");
    require("../biblioteca/funcoes.php");
	if(!$conexao) header("Location: ../erros/bd_erro/");
	session_start();
	if(isset($_SESSION['adm_configurado'])){
			if($_SESSION['adm_configurado'] == false){
				$titulo = "Configuração Inicial - SaGa";
				$link_redir = "../";
			}
			else{
				$titulo = "Configurações básicas";
				$link_redir = "../sistema";
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
			<form class="contact100-form validate-form">
				<span class="contact100-form-title">
                    <?php echo($titulo); ?>
                </span>
                
                <?php
                    if(
                        isset($_POST['nome']) and
                        isset($_POST['senha']) and
                        isset ($_POST['c_senha']) and
                        isset($_POST['mensagem'])
                    ){
                        $nome_empresa = mysqli_real_escape_string($conexao, trim($_POST['nome']));
						$senha = mysqli_real_escape_string($conexao, $_POST['senha']);
						$c_senha = mysqli_real_escape_string($conexao, $_POST['c_senha']);
						$mensagem = mysqli_real_escape_string($conexao, trim($_POST['mensagem']));


                        if($senha == $c_senha){
                            if(!empty($_FILES['foto_login']['name'])){
                                $foto = $_FILES['foto_login'];

								if(exif_imagetype($foto['tmp_name']) !== false) {
									$destino = "../images/".$foto['name'];
									move_uploaded_file($foto['tmp_name'], $destino);
									$destino = "./images/".$foto['name'];
								} else {
									echo("<div class='alert alert-danger text-center wrap-input100' role='alert'>O arquivo enviado não é uma imagem válida.</div>");
								}
                            }else{
								if(!$_SESSION['adm_configurado']) $destino = "./configuracao/dados/imagem_padrao.jpg";
								else{
									$destino = mysqli_fetch_array(mysqli_query($conexao, "select *, foto_login as url_img  from configuracao"));
									$destino = $destino['url_img'];
								}
							}
                            echo "<pre>";
							var_dump($_FILES);
							echo "</pre>";
                            $comando = "UPDATE `configuracao` SET `nome`='$nome_empresa',`foto_login`='$destino',`mensagem_login`='$mensagem' WHERE 1";
                            $resultado = mysqli_query($conexao, $comando);
                            if(mysqli_affected_rows($conexao)){
                                echo("<div class='alert alert-success text-center wrap-input100' role='alert'>Configuração efetuada com sucesso.</div>");
                                $comando = "UPDATE `usuario` SET `nome`='$nome_empresa',`adm_configurado`=1,`senha`=AES_ENCRYPT('$senha', 'token') WHERE usuario='admin'";
								$resultado = mysqli_query($conexao, $comando);
								if($_SESSION['adm_configurado'] == false) session_destroy();
                                redir($link_redir, 3);
                            }else{
                                echo("<div class='alert alert-danger text-center wrap-input100' role='alert'>Houve um erro, tente novamente.</div>");
                            }
                        }else{
                            echo("<div class='alert alert-danger text-center wrap-input100' role='alert'>Sua senha e a confirmação da mesma não coincidem.</div>");
                        }
                    }else{
                        echo("<div class='alert alert-danger text-center wrap-input100' role='alert'>Você não preencheu algum dado.</div>");
                    }
                ?>
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
		$(document).ready(function(){
			$("#btnConfirma").click(function(){
				$.get("processa_dados_config.php", {

				})
			});
		});

	</script>

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
