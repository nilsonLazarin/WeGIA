<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Seja um Sócio</title>
	<meta charset="UTF-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="./js/validacep.js"></script>
	<script type="text/javascript" src="./js/outros.js"></script>
	<script type="text/javascript" src="./js/data.js"></script>
	<script type="text/javascript" src="./js/cpfcnpj.js"></script>
	<script type="text/javascript" src="./js/telefone.js"></script>
	<script type="text/javascript" src="./js/boletoFacil.js"></script>
	<script type="text/javascript" src="./js/converte.js"></script>
	<script type="text/javascript" src="./js/verificar.js"></script>
	<script type="text/javascript" src="./js/verificar2.js"></script>
	<script type="text/javascript" src="./js/verificar3.js"></script>
	<script type="text/javascript" src="./js/validacpf.js"></script>
	<script type="text/javascript" src="./js/validacnpj.js"></script>
	<script type="text/javascript" src="./js/valida_email.js"></script>
	<script type="text/javascript" src="./js/recebeD.js"></script>
	<script type="text/javascript" src="./js/retornadia.js"></script>
	<script type="text/javascript" src="./js/cartaodunica.js"></script>
	<script type="text/javascript" src="./js/cartaodmensal.js"></script>
	<script type="text/javascript" src="./js/sociotipo.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	

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
<!--===============================================================================================-->
		
		<style>
			.radio{
    			position: absolute;
    			opacity: 0;
    			cursor:pointer;
			}
			input[type=radio]+label {
				padding: 5px;
    			font-weight: normal;
			}
			input[type=radio]:hover+label {
				background-color: white;
				border: 2px rgb(169,169,169) solid;
			}
			input[type=radio]+label {
   			 	font-weight: normal;
    			border: 2px solid lightgray;
    			border-radius: 5px;
    			background-color: lightgray ;
			}
			input[type=radio]:checked+label {
				background-color: rgb(65,105,225);
				border: 1px rgb(169,169,169) solid;
   				font-weight: bold;
			}
			input[type=radio]:focus+label {
				background-color: rgb(65,105,225);
				border: 1px rgb(169,169,169) solid;
    			/*border: 2px dotted #000;*/
			}
			#info_data 
			{
			    color: red;
			    font-size: 15px;
			}
			#aviso_data
			{
				color: red;
				font-size:15px;
			}
			#avisa_cpf
			    {
				color: red;
				font-size: 20px;
				font-family: 'Bitter', serif;
			    }
			#avisa_cnpj
			    {
				color: red;
				font-size: 20px;
				font-family: 'Bitter', serif;
			    }
			#avisa_valor
			    {
				color: red;
				font-size: 20px;
				font-family: 'Bitter', serif;
			    }
			#avisoPF
			{
				color: red;
				font-size: 20px;
				font-family: 'Bitter', serif;
			}
			#avisoPJ
			{
				color: red;
				font-size: 20px;
				font-family: 'Bitter', serif;
			}
			#aviso
			{
				color: red;
				font-size: 20px;
				font-family: 'Bitter', serif;
			}
            #avisa_valor2			    
				{
				color: red;
				font-size: 20px;
				font-family: 'Bitter', serif;
			    }
			#avisa_email			    
			{
				color: red;
				font-size: 20px;
				font-family: 'Bitter', serif;
			}
			
			button{
				border-radius: 5px;
				border: 1px rgb(143,188,143) solid;
				padding: 5px;
				margin: 5px;
			}
			#trinta{
				background-color: rgb(34,139,34); 
			}
			#quarenta{
				background-color: rgb(139,0,0); 
			}
			#cinquenta{
				background-color: rgb(255,140,0); 
			}
			#cem{
				background-color: rgb(28,28,28); 
			}
			#cento50{
				background-color: rgb(218,165,32); 
			}
			#duzentos{
				background-color: rgb(160,82,45); 
			}
			#duzentos50{
				background-color: rgb(165,42,42); 
			}
			#trezentos{
				background-color: rgb(128,0,128); 
			}
			#quinhentos{
				background-color: rgb(107,142,35); 
			}
			#mil{
				background-color: rgb(139,0,0); 
			}
			#trinta:hover,#cinquenta:hover,#cem:hover,#cento50:hover,#duzentos:hover,#duzentos50:hover,#trezentos:hover,#quinhentos:hover,#mil:hover{
				background-color: rgb(65,105,225);
				border: 1px rgb(169,169,169) solid;
				
			}
			a:hover{
				color: white;
				text-decoration:none;
			}
			a{ 
				font-weight: normal;	
				color: white;

			}
			.mala {
				
				background-color: rgb(65,105,225);
				padding: .5rem 1rem;
				border-radius: .3rem;
			}
		</style>
</head>
<body>

	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" method = "POST" name="f2" >
				<img style="margin:0 auto;" src="outros/images/logo.png">
				<span class="contact100-form-title">
					SEJA UM DOADOR
				</span>

				<div id="pag1" class="wrap-input100">
					<div id="forma">
						<h3>DEFINA UMA FORMA DE PAGAMENTO:</h3>
						<span id = "cartao">
							<input class = "radio" type = "radio"  name = "forma" id = "forma1" value = "cartao">
							<label  class="label" for = "forma1">CARTÃO DE CRÉDITO</label>
						</span>
						<span id = "dinheiro">
							<input  class = "radio" type = "radio"  name = "forma" id = "forma2" value = "1" checked>
							<label class="label"  for = "forma2">BOLETO BANCÁRIO</label>
						</span><br><br>
					</div>
					
						<div id="tipo_cartao">
							<h3>TIPO DE DOAÇÃO:</h3>
							<span id = "mensal_cartao"><input class = "radio" type = "radio"  name = "tipoc1" id = "tipoc1" checked>
							<label  class="label" for = "tipoc1">DOAÇÃO MENSAL</label></span>

							<span id = "unica_cartao"><input class = "radio" type = "radio"  name = "tipoc2" id = "tipoc2">
							<label  class="label" for = "tipoc2">DOAÇÃO ÚNICA</label></span>
						</div>
					
						<div id = "cartao_mensal">
							<button id="trinta" class="btn"></button>
							<button class="btn" id="quarenta"></button>
							<button class="btn" id="cinquenta"></button>
							<button class="btn" id="cem"></button>
						</div>

						<div id="cartao_unica">
							<span id="paypal"></span>

							<span id="pagseguro"></span>
						</div>

					<div id="doacao_boleto">
						<h3>TIPO DE DOAÇÃO:</h3>

						<span id = "m"><input class = "radio" type = "radio"  name = "tipo" id = "tipo1" value = "M" checked>
						<label  class="label" for = "tipo1">DOAÇÃO MENSAL</label></span>

						<span id = "u"><input class = "radio" type = "radio"  name = "tipo" id = "tipo2" value = "U">
						<label  class="label" for = "tipo2">DOAÇÃO ÚNICA</label></span>


						<div id = "input" class="wrap-input100 validate-input bg1">
							<span class="label-input100">Digite um valor</span>
							<input class="input100" type = 'number' id = 'v' name = 'v' placeholder="Digite um valor de doação única." onblur = "toReal(f2.v);" required>
						<p id = "avisa_valor"></p>
						</div>

						<div id = "valores" class="wrap-input100 input100-select bg1">
							<span class="label-input100">Valor *</span>
							<select class="js-select2" name="service">
								<option value=''>Selecione um valor</option>
								<option value = '30.00'>R$30,00</option>
								<option value = '50.00'>R$50,00</option>
								<option value = '100.00'>R$100,00</option>
								<option value = '150.00'>R$150,00</option>
								<option value = '200.00'>R$200,00</option>
								<option value = '250.00'>R$250,00</option>
								<option value = '300.00'>R$300,00</option>
								<option value = '500.00'>R$500,00</option>
								<option value = '1000.00'>R$1000,00</option>
							</select>
							<div class="dropDownSelect2"></div>
						<p id = "avisa_valor2"></p>
						</div>
						
						<div id = "venci" class="wrap-input100 validate-input bg1">
							<span class="label-input100">Vencimento *</span><br>
							<input type = "radio" value ="1" id ="dia1" name = "dta"> 1
							<input type = "radio" value ="5" id ="dia5"name = "dta"> 5
							<input type = "radio" value ="10" id ="dia10"name = "dta"> 10
							<input type = "radio" value ="15" id ="dia15"name = "dta"> 15
							<input type = "radio" value ="20" id ="dia20"name = "dta"> 20
							<input type = "radio" value ="25" id ="dia25"name = "dta">25
							<br>
							<span id="info_data" ></span>
						</div>

						<div class="container-contact100-form-btn">
							<button class="contact100-form-btn" id="avanca">
									AVANÇAR
									<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</button>							
						</div>

					</div>	
				</div>

				<div id="pag2" class="wrap-input100">

                    <input class = "radio" type="radio" id="op_cpf" value="fisica" name="opcao" onblur="fisjur(f2.opcao)" checked><label  class="label" for = "op_cpf">PESSOA FÍSICA</label>
                    <input class = "radio" type="radio" id="op_cnpj" value="juridica" name="opcao" onblur="fisjur(f2.opcao)"><label  class="label" for = "op_cnpj">PESSOA JURÍDICA</label><br><br>
                

                    <h3>INFORMAÇÕES PESSOAIS</h3><br>

                    <div class="wrap-input100 validate-input bg1" data-validate="Por Favor Digite seu Nome" id = "nc">
                            <span class="label-input100">NOME *</span>
                            <input class="input100" type="text" name="nome" id="nome" class="text required" placeholder="Digite seu Nome" required>
                    </div>

                    <div class="wrap-input100 validate-input bg1" data-validate="Por Favor Digite o Nome" id = "jnome">
                            <span class="label-input100">NOME *</span>
                            <input class="input100" type="text" name="cnpj_nome" id="cnpj_nome" placeholder="Digite seu nome" required>
                    </div>
					<div class="wrap-input100 validate-input bg1" data-validate="Por Favor Digite o Sobrenome" id="sobrenome">
                            <span class="label-input100">SOBRENOME *</span>
                            <input class="input100" type="text" name="sobrenome" id="sobrenome" placeholder="Digite seu sobrenome" required>
                    </div>

                    <div class="wrap-input100 validate-input bg1" style="height: 90px" id = "nascimento">
                            <span class="label-input100">DATA DE NASCIMENTO *</span><br>
                                    
                            <select style="width: 30%" class="wrap-input100 validate-input bg1" name="dia" id="dia" onblur="valida_data(f2.dia)" class="text required" > 
                                    <option value="">Dia</option>
                                    <?php

                                        for($i=1; $i<=31; $i++)
                                        {
                                            echo("<option value='".$i."'>".$i."</option>");
                                        }
                                    ?>
                                    </select>
                            <select style="width: 33%" class="wrap-input100 validate-input bg1" name="mes" id="mes" onblur="valida_data(f2.mes)">
                                        <option value="">Mês</option>
                                        <option value="01">Janeiro</option>
                                        <option value="02">Fevereiro</option>
                                        <option value="03">Março</option>
                                        <option value="04">Abril</option>
                                        <option value="05">Maio</option>
                                        <option value="06">Junho</option>
                                        <option value="07">Julho</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                            </select>
                            <select style="width: 30%" class="wrap-input100 validate-input bg1" name="ano" id="ano" onblur="valida_data(f2.ano)">
                                        <option value="">Ano</option>
                                        <?php
                                            for($i=date('Y')-10; $i>=(date('Y')-100); $i--)
                                            {
                                                echo("<option value='".$i."'>".$i."</option>");
                                            }
                                        ?>
                            </select>
                                    <span id="aviso_data" class="label-input100"></span>	
                        </div>

                    <div class="wrap-input100 validate-input bg1" data-validate="Digite um telefone Válido">
                            <span class="label-input100">TELEFONE *</span>
                            <input class="input100" type="text" name="telefone" id="telefone" onblur="valida_telefone(f2.telefone)" class="text required" placeholder="(22)22222-2222" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
                    </div>

                    <div class="wrap-input100 validate-input bg1">
                            <span class="label-input100">E-mail*</span>
							<input class="input100" type="text" name="email" id="email"  class="text required" placeholder="Digite seu e-mail" onblur = "valida_email(this.value)" required>
							<p id = "avisa_email"></p>
                    </div>

                    <div id="cpf" class="wrap-input100 validate-input bg1" data-validate = "Digite um documento válido!">
                            <span class="label-input100">CPF *</span>
                            <input class="input100" type="text" name="dcpf" id="dcpf" class="text required"placeholder="Ex: 222.222.222-22"  onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" required><span id = "avisa_cpf"></span>
                    </div>

                    <div id="cnpj" class="wrap-input100 validate-input bg1" data-validate = "Digite um documento válido!">
                            <span class="label-input100">CNPJ *</span>
                            <input class="input100" type="text" name="dcpf" id="dcnpj" onkeyup="FormataCnpj(this,event)"  maxlength="18" class="form-control input-md" ng-m placeholder = "22.222.222/2222-22"><span id = "avisa_cnpj"></span>
							
                    </div>
					<br>

					<p id = "avisoPF"></p>
					<p id = "avisoPJ"></p>

					<br>
                    <div class="container-contact100-form-btn">
                        <span class="contact100-form-btn" id = "volta">
                        <i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i> VOLTAR
                        </span>							
                    </div>

                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca2">
                                                AVANÇAR
                        <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>							
                    </div>

                </div>

				<div class="wrap-input100" id = "pag3">
					<h3>ENDEREÇO</h3><br>
					<div class="wrap-input100 validate-input bg1" data-validate = "Digite um CEP válido">
						<span class="label-input100">CEP</span>
						<input class="input100" type="text" id="cep" name="cep" onkeypress="$(this).mask('00.000-000')" onblur="valida_cep(f2.cep)" class="text required" placeholder="Digite um CEP" required>
					</div>
					<div class="wrap-input100 validate-input bg1">
						<span class="label-input100">LOGRADOURO</span>
						<input class="input100" type="text" id="rua" name="rua" onblur="valida_endereco(f2.rua)" class="text required" placeholder="Digite um Logradouro" required>
					</div>
					<div class="wrap-input100 bg1">
						<span class="label-input100">NÚMERO</span>
						<input class="input100" type="text" id="numero" name="numero" class="text required" placeholder="Digite o Número" required>
					</div>
					<div class="wrap-input100 bg1">
						<span class="label-input100">COMPLEMENTO</span>
						<input class="input100" type="text" id="complemento" name="complemento" placeholder="Digite o Complemento">
					</div>
					<div class="wrap-input100 validate-input bg1">
						<span class="label-input100">BAIRRO</span>
						<input class="input100" type="text" id="bairro" name="bairro" onblur="valida_endereco(f2.bairro)" class="text required" placeholder="Digite um Bairro" required>
					</div>
					<div class="wrap-input100 validate-input bg1">
						<span class="label-input100">CIDADE</span>
						<input class="input100" type="text" id="localidade" name="localidade" onblur="valida_endereco(f2.localidade)" class="text required" placeholder="Digite a Cidade" required>
					</div>
					<div class="wrap-input100 validate-input bg1">
						<span class="label-input100">ESTADO</span>
						<select class="wrap-input100 validate-input bg1" id="uf" name="uf" onblur="valida_endereco(f2.estado); geraArquivo()" class="text required">
							<option value="" disabled></option>
			    			<option value="AC">Acre</option>
			    			<option value="AL">Alagoas</option>
			    			<option value="AP">Amapá</option>
			    			<option value="AM">Amazonas</option>
			    			<option value="BA">Bahia</option>
			    			<option value="CE">Ceará</option>
			    			<option value="DF">Distrito Federal</option>
			    			<option value="ES">Espírito Santo</option>
			    			<option value="GO">Goiás</option>
			    			<option value="MA">Maranhão</option>
			    			<option value="MT">Mato Grosso</option>
			    			<option value="MS">Mato Grosso do Sul</option>
			   			 	<option value="MG">Minas Gerais</option>
			    			<option value="PA">Pará</option>
			    			<option value="PB">Paraíba</option>
			    			<option value="PR">Paraná</option>
			    			<option value="PE">Pernambuco</option>
			   			    <option value="PI">Piauí</option>
			    			<option value="RJ">Rio de Janeiro</option>
			    			<option value="RN">Rio Grande do Norte</option>
			    			<option value="RS">Sergipe</option>
			    			<option value="TO">Tocantins</option>
			    		</select><br>
					</div>
					<p id="lista" name="lista"></p>
					<!--input type = "submit" value = "enviar" id="enviar" disabled-->

					<p id = "aviso"></p>

					<div class="container-contact100-form-btn">
						<span class="contact100-form-btn" id = "volta2">
							<i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
							VOLTAR
						</span>							
					</div>

					<div class="container-contact100-form-btn">
						<button class="contact100-form-btn" value = "GERAR BOLETO" id = "avanca3">GERAR BOLETO</button>					
					</div>
				</div>
			</form>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"/></script>
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

		$(document).ready(function(){	
			$("#dcnpj").mask("99.999.999/9999-99");
		});

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
	<script src="outros/js/main.js"></script>
	<script src="outros/js/mascara.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->


<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>

<script>

  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

<script>

	    $(document).ready(function()
	    {
			cartaodunica();
			cartaodmensal();
			$("#tipo_cartao").hide();
			$("#cartao_mensal").hide();
			$("#cartao_unica").hide();
			$("#input").hide();
			$("#pag2").hide();
			$("#pag3").hide();
			$("#cnpj").hide();
			$("#info_valor").hide();
			$("#nc").show();
			$("#jnome").hide();
			$("#trinta").hide();
            $("#quarenta").hide();
            $("#cinquenta").hide();
            $("#cem").hide();
			
			
		
	    $("#cartao").click(function()
		{
			$("#doacao_boleto").hide();
			$("#tipo_cartao").fadeIn();
			$("#cartao_mensal").fadeIn();
			$("#trinta").show();
            $("#quarenta").show();
            $("#cinquenta").show();
            $("#cem").show();
			$("#tipoc2").prop("checked", false);
			$("#tipoc1").prop("checked", true);
			

		});
		$("#mensal_cartao").click(function(){
			$("#cartao_unica").hide();
			$("#cartao_mensal").fadeIn();
			$("#tipoc2").prop("checked", false);
			$("#tipoc1").prop("checked", true);
			
		});
		$("#unica_cartao").click(function(){
			$("#cartao_unica").fadeIn();
			$("#cartao_mensal").hide();
			$("#tipoc2").prop("checked", true);
			$("#tipoc1").prop("checked", false);
		});

		$("#dinheiro").click(function()
		{
			$("#tipo_cartao").hide();
			$("#cartao_mensal").hide();
			$("#cartao_unica").hide();
			$("#doacao_boleto").fadeIn();
			$("#tipo1").prop('checked', true);
			

		});

		$("#op_cpf").click(function()
		{
			$("#nc").show();
			$("#sobrenome").show();
			$("#jnome").hide();
		    $("#cpf").fadeIn();
		    $("#cnpj").hide();  
			$("#nascimento").show();
			$("#dia").show();
			$("#mes").show();
			$("#ano").show();
			$("#avisoPF").show();
			$("#avisoPJ").hide();
			
			
		});

		$("#op_cnpj").click(function()
		{
		    $("#cpf").hide(); 
		    $("#cnpj").fadeIn();
			$("#dia").hide();
			$("#mes").hide();
			$("#ano").hide();
			$("#nascimento").hide(); 
			$("#avisoPF").hide();
			$("#avisoPJ").show();
			$("#nc").hide();
			$("#jnome").show();
			$("#sobrenome").hide();
		});  

		$("#u").click(function()
		{
		    $("#valores").hide();
			$("#input").fadeIn();
			$("#venci").hide();
			
		});


		$("#m").click(function()
		{
		    $("#valores").show();
		    $("#venci").show();
			$("#input").hide();
			//$("#ola").hide();
		});

		$("#avanca").click(function()
		{
			verificar();
		    /*$("#pag2").fadeIn();
		    $("#pag1").hide();
		    $("#forma").hide();
			$("#doacao").hide();*/	
		});

		$("#avanca2").click(function()
		{
			verifica2();
		});
		$("#avanca3").click(function()
		{
			verifica3();
			
		});

		$("#volta").click(function(){

			$("#pag2").hide();
			$("#pag1").fadeIn();
			$("#doacao_boleto").fadeIn();
			$("#forma").fadeIn();
			
		});

		$("#volta2").click(function()
		{
			
			$("#pag3").hide();
			$("#pag2").fadeIn();
		});

	});

	</script>

</body>
</html>
<?php

