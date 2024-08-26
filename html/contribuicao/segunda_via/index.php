<?php
include("../php/conexao.php");
include("../php/preencheForm.php");
include("../php/logo_titulo.php");
ini_set('display_errors', 0);
ini_set('display_startup_erros', 0);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Emita sua 2° via do boleto</title>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../../Functions/onlyNumbers.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../outros/css/index.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Bitter&display=swap" rel="stylesheet">
    <!--
=========================================================================================-->

    <link rel="stylesheet" type="text/css" href="../outros/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../outros/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../outros/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../outros/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../outros/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../outros/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../outros/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../outros/vendor/noui/nouislider.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../outros/css/util.css">
    <link rel="stylesheet" type="text/css" href="../outros/css/main.css">
    <link rel="stylesheet" type="text/css" href="../outros/css/donation.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/segundaVia.css">

    <!--===============================================================================================-->
    <style>
        #logo_img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        #avisoPf {
            font-size: 20px;
            color: red;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        #avisoPj {
            font-size: 20px;
            color: red;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        .pultima_div {
            margin-left: auto;
            margin-right: auto;
        }

        .loader {
            border: 1px solid #f3f3f3;
            border-radius: 50%;
            border-top: 1px solid #3498db;
            width: 20px;
            height: 20px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            margin: 0 auto !important;
        }

       

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container-contact100">
        <div class="wrap-contact100">

            <span id="logo_img"><?php resgataImagem(); ?></span>
            <span class="contact100-form-title" id="titulo_pag"><?php resgataParagrafo(); ?></span>

            <input type="hidden" name="forma-contribuicao" id="forma-contribuicao" value="boleto">

            <div id="pag1" class="wrap-input100">

                <div class="centralizar">
                    <input class="radio" type="radio" id="op_cpf" value="fisica" name="opcao" checked><label class="label" for="op_cpf">PESSOA FÍSICA</label>
                    <input class="radio" type="radio" id="op_cnpj" value="juridica" name="opcao"><label class="label" for="op_cnpj">PESSOA JURÍDICA</label><br><br>
                </div>

                <div id="cpf" class="wrap-input100 validate-input bg1" data-validate="Digite um documento válido!">
                    <span class="label-input100">Digite um documento CPF*</span>
                    <input class="input100" type="text" name="dcpf" id="dcpf" class="text required" placeholder="Ex: 222.222.222-22" onkeyup="return Onlynumbers(event)" onkeypress="mascara('###.###.###-##',this,event)" maxlength="14" required><span id="avisa_cpf"></span>
                </div>

                <div id="cnpj" class="wrap-input100 validate-input bg1 hidden" data-validate="Digite um documento válido!">
                    <span class="label-input100"> Digite um documento CNPJ *</span>
                    <input class="input100" type="text" name="dcpf" id="dcnpj" maxlength="18" class="form-control input-md" ng-m placeholder="Ex: 22.222.222/2222-22" onkeypress="mascara('##.###.###/####-##',this,event)"><span id="avisa_cnpj"></span>
                </div>
                <div class="container-contact100-form-btn">
                    <button class="contact100-form-btn" id="consultar-btn">
                        AVANÇAR
                        <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div id="pag2" class="wrap-input100 hidden">
                <div id="tabela-boletos"></div>
                <div class="container-contact100-form-btn">
					<button class="contact100-form-btn" id="voltar-btn">
						<i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i> VOLTAR
					</button>
				</div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script src="../outros/vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="../outros/vendor/select2/select2.min.js"></script>
    <script src="../outros/js/mascara.js"></script>

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
        function setLoader(btn) {
            // Esconde o primeiro elemento filho (ícone)
            btn.firstElementChild.style.display = "none";

            // Remove o texto do botão sem remover os elementos filhos
            btn.childNodes.forEach(node => {
                if (node.nodeType === Node.TEXT_NODE) {
                    node.textContent = '';
                }
            });

            // Adiciona o loader se não houver outros elementos filhos além do ícone
            if (btn.childElementCount == 1) {
                var loader = document.createElement("DIV");
                loader.className = "loader";
                btn.appendChild(loader);
            }
        }
    </script>
    <script src="./assets/js/segundaVia.js"></script>
</body>

</html>