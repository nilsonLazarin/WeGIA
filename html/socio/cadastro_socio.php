<?php
ini_set('display_errors', 0);
ini_set('display_startup_erros', 0);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Seja um sócio apoiador!</title>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../contribuicao/public/css/index.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Bitter&display=swap" rel="stylesheet">
    <!--
=========================================================================================-->

    <link rel="stylesheet" type="text/css" href="../contribuicao/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/public/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/public/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/vendor/noui/nouislider.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../contribuicao/public/css/util.css">
    <link rel="stylesheet" type="text/css" href="../contribuicao/public/css/main.css">
    <link rel="stylesheet" type="text/css" href="../contribuicao/public/css/donation.css">

    <script type="text/javascript" src="../../Functions/onlyNumbers.js"></script>
    <script type="text/javascript" src="../../Functions/testaCPF.js"></script>
    <script src="../../Functions/busca_cep.js"></script>
    <script src="../contribuicao/public/js/mascara.js"></script>
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

        span.obrigatorio {
            color: red;
        }

        .btn-voltar {
            font-size: .9rem;
        }

        .btn-voltar:hover {
            font-size: 1rem;
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="container-contact100">
        <div class="wrap-contact100">
            <?php require_once '../contribuicao/controller/BrandController.php';

            $brandController = new BrandController();
            $brand = $brandController->getBrand();
            ?>

            <span id="logo_img">
                <?php
                if (!is_null($brand)) {
                    echo $brand->getImagem()->getHtml();
                }
                ?>
            </span>
            <span class="contact100-form-title" id="titulo_pag">
                <?php
                if (!is_null($brand)) {
                    echo $brand->getMensagem();
                }
                ?>
            </span>

            <h3 class="text-center">Formulário de cadastro</h3>
            <p class="text-center">Campos obrigatórios <span class="obrigatorio">*</span></p>
            <div id="mensagem">

            </div>
            <form action="" name="cadastro" id="form-cadastro">

                <input type="hidden" name="acao" id="acao" value="cadastrar">

                <div id="pag1" class="wrap-input100">

                    <div class="wrap-input100">
                        <label for="valor" class="label-input100">Com quanto deseja contribuir? <span class="obrigatorio">*</span></label>
                        <input type="number" class="input100" name="valor" id="valor" placeholder="Digite o valor da sua contribuição">
                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn btn-acao" id="avanca-valor">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                </div>

                <div id="pag2" class="wrap-input100 hidden">

                    <div class="wrap-input100">
                        <label for="cpf" class="label-input100">Para prosseguirmos precisamos do seu CPF <span class="obrigatorio">*</span></label>
                        <input type="text" class="input100" name="cpf" id="cpf" placeholder="Informe o seu CPF" onkeyup="return Onlynumbers(event)" onkeypress="mascara('###.###.###-##',this,event)" maxlength="14">
                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-cpf">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn btn-voltar" id="volta-valor">
                            <i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
                            VOLTAR
                        </button>
                    </div>

                </div>

                <div id="pag3" class="wrap-input100 hidden">

                    <div class="wrap-input100">
                        <label for="nome" class="label-input100">Nome <span class="obrigatorio">*</span></label>
                        <input type="text" class="input100" name="nome" id="nome" placeholder="Informe seu nome completo">
                    </div>
                    <div class="wrap-input100">
                        <label for="data_nascimento" class="label-input100">Data de Nascimento <span class="obrigatorio">*</span></label>
                        <input type="date" class="input100" name="data_nascimento" id="data_nascimento" min="1900-01-01" max="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="wrap-input100">
                        <label for="email" class="label-input100">E-mail <span class="obrigatorio">*</span></label>
                        <input type="text" class="input100" name="email" id="email" placeholder="Informe seu e-mail">
                    </div>
                    <div class="wrap-input100">
                        <label for="telefone" class="label-input100">Telefone <span class="obrigatorio">*</span></label>
                        <input type="text" class="input100" name="telefone" id="telefone" placeholder="Informe seu número de telefone para contato" onkeypress="mascara('(##)#####-####',this,event); return Onlynumbers(event)" maxlength="14">
                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn btn-acao" id="avanca-contato">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>

                        <div class="container-contact100-form-btn">
                            <button class="contact100-form-btn btn-voltar" id="volta-cpf">
                                <i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
                                VOLTAR
                            </button>
                        </div>
                    </div>

                </div>

                <div id="pag4" class="wrap-input100 hidden">
                    <div class="wrap-input100 validate-input bg1">
                        <span class="label-input100">Com qual frequência gostaria de contribuir? <span class="obrigatorio">*</span></span>
                        <select class="wrap-input100 validate-input bg1" id="periodicidade" name="periodicidade">
                            <option value="" disabled selected>Selecione uma opção...</option>
                            <option value="2">Mensal</option>
                            <option value="6">Bimestral</option>
                            <option value="8">Trimestral</option>
                            <option value="10">Semestral</option>
                        </select>
                    </div>

                    <div id="vencimento" class="wrap-input100 validate-input bg1">
                        <span class="label-input100">Escolha uma data de vencimento <span class="obrigatorio">*</span></span><br>
                        <input type='radio' value='01' name='data_vencimento' id='data_vencimento01'><span style='margin-right: 1.5em'>1</span>
                        <input type='radio' value='05' name='data_vencimento' id='data_vencimento05'><span style='margin-right: 1.5em'>5</span>
                        <input type='radio' value='10' name='data_vencimento' id='data_vencimento10'><span style='margin-right: 1.5em'>10</span>
                        <input type='radio' value='15' name='data_vencimento' id='data_vencimento15'><span style='margin-right: 1.5em'>15</span>
                        <input type='radio' value='20' name='data_vencimento' id='data_vencimento20'><span style='margin-right: 1.5em'>20</span>

                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-periodo">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn btn-voltar" id="volta-contato">
                            <i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
                            VOLTAR
                        </button>
                    </div>
                </div>

                <div id="pag5" class="wrap-input100 hidden">

                    <div class="wrap-input100">
                        <label for="cep" class="label-input100">CEP <span class="obrigatorio">*</span></label>
                        <input type="text" class="input100" name="cep" id="cep" placeholder="Informe o CEP do seu endereço" onkeypress="$(this).mask('00000-000')" onblur="pesquisacep(this.value)">
                    </div>
                    <div class="wrap-input100">
                        <label for="rua" class="label-input100">Rua <span class="obrigatorio">*</span></label>
                        <input type="text" class="input100" name="rua" id="rua" placeholder="Informe o nome da sua rua">
                    </div>
                    <div class="wrap-input100">
                        <label for="numero" class="label-input100">Número <span class="obrigatorio">*</span></label>
                        <input type="text" class="input100" name="numero" id="numero" placeholder="Informe o número da sua residência">
                    </div>
                    <div class="wrap-input100">
                        <label for="bairro" class="label-input100">Bairro <span class="obrigatorio">*</span></label>
                        <input type="text" class="input100" name="bairro" id="bairro" placeholder="Informe o nome do seu bairro">
                    </div>
                    <div class="wrap-input100 validate-input bg1">
                        <span class="label-input100">Estado <span class="obrigatorio">*</span></span>
                        <select class="wrap-input100 validate-input bg1" id="uf" name="uf">
                            <option value="Selecione sua unidade federativa" disabled></option>
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
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="RS">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select><br>
                    </div>
                    <div class="wrap-input100">
                        <label for="cidade" class="label-input100">Cidade <span class="obrigatorio">*</span></label>
                        <input type="text" class="input100" name="cidade" id="cidade" placeholder="Informe o nome da sua cidade">
                    </div>
                    <div class="wrap-input100">
                        <label for="complemento" class="label-input100">Complemento</label>
                        <input type="text" class="input100" name="complemento" id="complemento" placeholder="Caso julgue interessante, forneça um complemento">
                    </div>

                    <input type="hidden" name="ibge" id="ibge" value="">
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-endereco">
                            AVANÇAR
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn btn-voltar" id="volta-periodo">
                            <i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
                            VOLTAR
                        </button>
                    </div>

                </div>

                <div id="pag6" class="wrap-input100 hidden">

                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn" id="avanca-terminar">
                            Inscrever-se como sócio apoiador.
                            <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn btn-voltar" id="volta-endereco">
                            <i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7" aria-hidden="true"></i>
                            VOLTAR
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>

    <!--Busca cep-->
    <script src="../../Functions/busca_cep.js"></script>
    <script src="./js/cadastro_socio.js"></script>

</body>

</html>
<?php
