<?php
include("./php/conexao.php");

include("./php/preencheForm.php");
include("./php/logo_titulo.php");
ini_set('display_errors', 0);
ini_set('display_startup_erros', 0);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Escolha sua forma de contribuição</title>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="outros/css/index.css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Bitter&display=swap" rel="stylesheet">
	<!--
=========================================================================================-->

	<link rel="stylesheet" type="text/css" href="outros/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="outros/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="outros/fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="outros/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="outros/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="outros/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="outros/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="outros/vendor/noui/nouislider.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="outros/css/util.css">
	<link rel="stylesheet" type="text/css" href="outros/css/main.css">
	<link rel="stylesheet" type="text/css" href="outros/css/donation.css">

	<!--===============================================================================================-->
	<style>
		#logo_img {
			display: block;
			margin-left: auto;
			margin-right: auto;
		}

		.container-contact100 {
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.wrap-contact100 {
			text-align: center;
		}

		#doacao_boleto .btn-group {
			display: flex;
			justify-content: center;
			border-radius: 20px;
		}
	</style>
</head>

<body>
	<div class="container-contact100">
		<div class="wrap-contact100">
			<span id="logo_img"><?php resgataImagem(); ?></span>
			<span class="contact100-form-title" id="titulo_pag"><?php resgataParagrafo(); ?></span>

			<div id="pag1" class="wrap-input100">
				<div id="doacao_boleto">
					<h3>Escolha sua forma de contribuição:</h3>

					<a class="btn btn-secondary m-2" href="./doacao/index.php" role="button">Boleto Único</a>
					<a class="btn btn-secondary m-2" href="./mensalidade/index.php" role="button">Carnê de Mensalidades</a>
					<a class="btn btn-secondary m-2" href="./pix/index.php" role="button">PIX</a>

				</div>
			</div>
		</div>
	</div>


	<!--===============================================================================================-->
	<!--script src="outros/vendor/daterangepicker/moment.min.js"></script>
	<script src="outros/vendor/daterangepicker/daterangepicker.js"></script-->
	<!--===============================================================================================-->
	<!--script src="outros/vendor/countdowntime/countdowntime.js"></script-->
	<!--===============================================================================================-->
	<!--script src="outros/vendor/noui/nouislider.min.js"></script-->
	<!--===============================================================================================-->
	<!--script src="outros/vendor/jquery/jquery-3.2.1.min.js"></script-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
	<!--===============================================================================================-->
	<!--script src="../outros/vendor/animsition/js/animsition.min.js"></script-->
	<!--===============================================================================================-->
	<script src="outros/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="outros/vendor/select2/select2.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#field").keyup(function() {
				$("#field").val(this.value.match(/[0-9]*/));
			});
		});

		$(document).ready(function() {
			$("#dcnpj").mask("99.999.999/9999-99");
		});

		$(".js-select2").each(function() {
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});


			$(".js-select2").each(function() {
				$(this).on('select2:close', function(e) {
					if ($(this).val() == "Please chooses") {
						$('.js-show-service').slideUp();
					} else {
						$('.js-show-service').slideUp();
						$('.js-show-service').slideDown();
					}
				});
			});
		})
	</script>
	<script>
		var filterBar = document.getElementById('filter-bar');

		noUiSlider.create(filterBar, {
			start: [1500, 3900],
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

		filterBar.noUiSlider.on('update', function(values, handle) {
			skipValues[handle].innerHTML = Math.round(values[handle]);
			$('.contact100-form-range-value input[name="from-value"]').val($('#value-lower').html());
			$('.contact100-form-range-value input[name="to-value"]').val($('#value-upper').html());
		});
	</script>
	<!--===============================================================================================-->
	<script src="outros/js/main.js"></script>
	<script src="outros/js/mascara.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->


	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>

	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-23581568-13');
	</script>

	<script>
		$(document).ready(function() {
			transicoes();
		});
	</script>

	<script>
		$(document).ready(function() {
			$(".input-donation-method").hide();
		});

		// $("#tipo2").change(function (){
		// 	if ($(this).is(':checked')) {
		// 		$("#switch-donation-method").hide();
		// 		$(".input-donation-method").hide();
		// 		$(".input-donation-method").val("");
		// })



		// seleciona entre select ou input no valor de doacao
		$("#switch-donation-method").click(function() {
			$(".input-donation-method").show();
			$("#valores").val("");
			$("#valores").removeAttr("required");
		});

		$('#valores').change(function() {
			$(".input-donation-method").hide();
		});
	</script>


</body>

</html>
<?php
