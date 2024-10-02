<?php
include("../contribuicao/php/conexao.php");

include("../contribuicao/php/preencheForm.php");
include("../contribuicao/php/logo_titulo.php");
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

    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/vendor/noui/nouislider.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/css/util.css">
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/css/main.css">
    <link rel="stylesheet" type="text/css" href="../contribuicao/outros/css/donation.css">

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

        /*.wrap-contact100 {
            text-align: center;
        }*/

        #doacao_boleto .btn-group {
            display: flex;
            justify-content: center;
            border-radius: 20px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-contact100">
        <div class="wrap-contact100">
            <span id="logo_img"><?php resgataImagem(); ?></span>
            <span class="contact100-form-title" id="titulo_pag"><?php resgataParagrafo(); ?></span>

            <h3 class="text-center">Formulário de cadastro</h3>
            <form action="">
                <div id="pag1" class="wrap-input100">

                    <div class="wrap-input100">
                        <label for="valor" class="label-input100">Com quanto deseja contribuir?</label>
                        <input type="number" class="input100" name="valor" id="valor" placeholder="Digite o valor da sua contribuição">
                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-valor">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                </div>

                <div id="pag2" class="wrap-input100">

                    <div class="wrap-input100">
                        <label for="cpf" class="label-input100">Para prosseguirmos precisamos do seu CPF</label>
                        <input type="text" class="input100" name="cpf" id="cpf" placeholder="Informe o seu CPF">
                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-cpf">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="container-contact100-form-btn">
						<button class="contact100-form-btn" id="volta-valor">
							<i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
							VOLTAR
						</button>
					</div>

                </div>

                <div id="pag3" class="wrap-input100">

                    <div class="wrap-input100">
                        <label for="nome" class="label-input100">Nome</label>
                        <input type="text" class="input100" name="nome" id="nome" placeholder="Informe seu nome completo">
                    </div>
                    <div class="wrap-input100">
                        <label for="data_nascimento" class="label-input100">Data de Nascimento</label>
                        <input type="date" class="input100" name="data_nascimento" id="data_nascimento">
                    </div>
                    <div class="wrap-input100">
                        <label for="email" class="label-input100">E-mail</label>
                        <input type="text" class="input100" name="email" id="email" placeholder="Informe seu e-mail">
                    </div>
                    <div class="wrap-input100">
                        <label for="telefone" class="label-input100">Telefone</label>
                        <input type="text" class="input100" name="telefone" id="telefone" placeholder="Informe seu número de telefone para contato">
                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-contato">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>

                        <div class="container-contact100-form-btn">
						<button class="contact100-form-btn" id="volta-cpf">
							<i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
							VOLTAR
						</button>
					</div>
                    </div>

                </div>

                <div id="pag4" class="wrap-input100">
                    <div class="wrap-input100">
                        <div class="select2-container">
                            <label for="nome" class="label-input100">Com qual frequência gostaria de contribuir?</label>
                            <select name="periodicidade" id="periodicidade" class="select2-selection--single select2-selection__arrow ">
                                <option value="">Selecione a periodicidade da contribuição</option>
                            </select>
                        </div>
                    </div>


                    <div id="vencimento" class="wrap-input100 validate-input bg1">
                        <span class="label-input100">Escolha uma data de vencimento *</span><br>
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            if ($arrayData[$i] != 0) {
                                echo "<input type = 'radio' value ='" . $arrayData[$i] . "' name = 'data_vencimento' id='op" . $i . "'>" . "<span style='margin-right: 1.5em'>" . $arrayData[$i] . "</span>";
                            }
                        }
                        ?>
                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-periodo">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="container-contact100-form-btn">
						<button class="contact100-form-btn" id="volta-contato">
							<i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
							VOLTAR
						</button>
					</div>
                </div>

                <div id="pag5" class="wrap-input100">

                    <div class="wrap-input100">
                        <label for="cep" class="label-input100">CEP</label>
                        <input type="text" class="input100" name="cep" id="cep" placeholder="Informe o CEP do seu endereço">
                    </div>
                    <div class="wrap-input100">
                        <label for="rua" class="label-input100">Rua</label>
                        <input type="text" class="input100" name="rua" id="rua" placeholder="Informe o nome da sua rua">
                    </div>
                    <div class="wrap-input100">
                        <label for="bairro" class="label-input100">Bairro</label>
                        <input type="text" class="input100" name="bairro" id="bairro" placeholder="Informe o nome do seu bairro">
                    </div>
                    <div class="wrap-input100">
                        <label for="estado" class="label-input100">Estado</label>
                        <input type="text" class="input100" name="estado" id="estado" placeholder="Informe o nome do seu Estado">
                    </div>
                    <div class="wrap-input100">
                        <label for="cidade" class="label-input100">Cidade</label>
                        <input type="text" class="input100" name="cidade" id="cidade" placeholder="Informe o nome da sua cidade">
                    </div>
                    <div class="wrap-input100">
                        <label for="cidade" class="label-input100">Complemento</label>
                        <input type="text" class="input100" name="cidade" id="cidade" placeholder="Caso julgue interessante, forneça um complemento">
                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-endereco">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="container-contact100-form-btn">
						<button class="contact100-form-btn" id="volta-periodo">
							<i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
							VOLTAR
						</button>
					</div>

                </div>

                <div id="pag6" class="wrap-input100">

                    <h3 class="text-center">Obrigado por apoiar nossa Instituição!</h3>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-terminar">
                            Inscrever-se como sócio apoiador.
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="container-contact100-form-btn">
						<button class="contact100-form-btn" id="volta-endereco">
							<i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
							VOLTAR
						</button>
					</div>

                </div>
            </form>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <!--===============================================================================================-->
    <script src="../contribuicao/outros/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../contribuicao/outros/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="../contribuicao/outros/js/main.js"></script>
    <script src="../contribuicao/outros/js/mascara.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->


    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>

</body>

</html>
<?php
