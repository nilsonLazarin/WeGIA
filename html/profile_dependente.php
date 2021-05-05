<?php
session_start();

require_once "../dao/Conexao.php";
$pdo = Conexao::connect();

function urlGetParams()
{
    $params = "?";
    $first = true;
    foreach ($_GET as $key => $value) {
        $params .= ($first ? "" : "&") . $key . "=" . $value;
        $first = false;
    }
    return $params;
}

$config_path = "config.php";
if (file_exists($config_path)) {
    require_once($config_path);
} else {
    while (true) {
        $config_path = "../" . $config_path;
        if (file_exists($config_path)) break;
    }
    require_once($config_path);
}

require_once "./permissao/permissao.php";
permissao($_SESSION['id_pessoa'], 11, 7);

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$situacao = $mysqli->query("SELECT * FROM situacao");
$cargo = $mysqli->query("SELECT * FROM cargo");
$beneficios = $mysqli->query("SELECT * FROM beneficios");
$descricao_epi = $mysqli->query("SELECT * FROM epi");

// Adiciona a Função display_campo($nome_campo, $tipo_campo)
require_once "personalizacao_display.php";
require_once "../dao/Conexao.php";
require_once ROOT . "/controle/FuncionarioControle.php";
$cpf = new FuncionarioControle;
$cpf->listarCPF();

require_once ROOT . "/controle/InternoControle.php";
$cpf1 = new InternoControle;
$cpf1->listarCPF();

require_once "./funcionario/Documento.php";
$doc_funcionario = new DocumentoFuncionario($_GET["id_funcionario"]);

require_once "./geral/msg.php";

$dependente = $pdo->query("SELECT *, par.descricao AS parentesco
FROM funcionario_dependentes fdep
LEFT JOIN pessoa p ON p.id_pessoa = fdep.id_pessoa
LEFT JOIN funcionario_dependente_parentesco par ON par.id_parentesco = fdep.id_parentesco
WHERE fdep.id_dependente = " . $_GET['id_dependente'] ?? null);
$dependente = $dependente->fetchAll(PDO::FETCH_ASSOC)[0];
$dependente = json_encode($dependente);

?>
<!doctype html>
<html class="fixed">

<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <title>Perfil dependente</title>
    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="icon" href="<?php display_campo("Logo", 'file'); ?>" type="image/x-icon" id="logo-icon">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="icon" href="<?php display_campo("Logo", 'file'); ?>" type="image/x-icon" id="logo-icon">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme.css" />
    <!-- Skin CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
    <link rel="stylesheet" href="../css/profile-theme.css" />
    <!-- Head Libs -->
    <script src="../Functions/onlyNumbers.js"></script>
    <script src="../Functions/onlyChars.js"></script>
    <!--script src="../Functions/enviar_dados.js"></script-->
    <script src="../Functions/mascara.js"></script>
    <script src="../Functions/lista.js"></script>


    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="icon" href="<?php display_campo("Logo", 'file'); ?>" type="image/x-icon" id="logo-icon">

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="../assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="../assets/vendor/modernizr/modernizr.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- Vendor -->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

    <!-- JavaScript Custom -->
    <script src="./geral/post.js"></script>
    <script src="./geral/formulario.js"></script>

    <script>

        var dependente = <?= $dependente;?>;
        var formState = [];

        function formInfoPessoal(dep){
            console.log(dep);
            $("#nomeForm").val(dep.nome);
            $("#sobrenomeForm").val(dep.sobrenome);
            $("#telefone").val(dep.telefone);
            $("#nascimento").val(dep.nascimento)
            $("#pai").val(dep.nome_pai);
            $("#mae").val(dep.nome_mae);
            if (dep.sexo) {
                let radio = $("input:radio[name=gender]");
                radio.filter('[value='+dep.sexo+']').prop('checked', true);
            }
            if (dep.tipo_sanguineo){
                let select = $("#sanque");
                $("#sanque_"+dep.tipo_sanguineo.replace("+", "p").replace("-", "n").toLowerCase()).prop('selected', true);
            }
        }

        function formEndereco(dep){
            $("#cep").val(dep.cep);
            $("#uf").val(dep.estado);
            $("#cidade").val(dep.cidade);
            $("#bairro").val(dep.bairro);
            $("#rua").val(dep.logradouro);
            $("#complemento").val(dep.complemento);
            $("#ibge").val(dep.ibge);
            if (dep.numero_endereco == 'Não possui' || dep.numero_endereco == null) {
                $("#numResidencial").prop('checked', true).prop('disabled', true);
                $("#numero_residencia").prop('disabled', true);
            } else {
                $("#numero_residencia").val(dep.numero_endereco).prop('disabled', true);
                $("#numResidencial").prop('disabled', true);
            }
        }

        function switchForm(idForm){
            if (formState[idForm]){
                formState[idForm] = false;
                disableForm(idForm);
            }else{
                formState[idForm] = true;
                enableForm(idForm);
            }
        }

        function submitForm(idForm){
            var data = getFormPostParams(idForm);
            var url;
            switch (idForm) {
                case "infoPessoal":
                    url = "./pessoa/editar_info_pessoal.php";
                    break;
                case "formEndereco":
                    url = "./pessoa/editar_endereco.php";
                    break;
                default:
                    break;
            }
            console.log("id_pessoa="+dependente.id_pessoa+"&"+data);
            post(url, "id_pessoa="+dependente.id_pessoa+"&"+data, function(response){
                console.log(response)
            });
        }

        var id_dependente = <?= $_GET['id_dependente'] ?? null;?>;

        $(function() {
            $("#header").load("header.php");
            $(".menuu").load("menu.php");
            if (id_dependente){
                formInfoPessoal(dependente);
                formEndereco(dependente);
                disableForm("infoPessoal");
                disableForm("formEndereco");
            }
        });
    </script>


    <style type="text/css">
        .btn span.fa-check {
            opacity: 0;
        }

        .btn.active span.fa-check {
            opacity: 1;
        }

        #frame {
            width: 100%;
        }

        .obrig {
            color: rgb(255, 0, 0);
        }

        .form-control {
            padding: 0 12px;
        }

        .btn i {
            color: white;
        }
    </style>
</head>

<body>
    <section class="body">
        <div id="header"></div>
        <!-- end: header -->
        <div class="inner-wrapper">
            <!-- start: sidebar -->
            <aside id="sidebar-left" class="sidebar-left menuu"></aside>
            <!-- end: sidebar -->
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Perfil</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="home.php">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Páginas</span></li>
                            <li><span>Perfil</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
                <!-- start: page -->

                <!-- Mensagem -->
                <?php getMsgSession("msg", "tipo"); ?>


                <div class="panel">
                    <div class="panel-body">
                        <div class="tabs">

                            <ul class="nav nav-tabs tabs-primary">
                                <li class="active">
                                    <a href="#overview" data-toggle="tab">Visão Geral</a>
                                </li>
                                <li>
                                    <a href="#documentos" data-toggle="tab">Documentos</a>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <!-- 
                                    Aba de visão geral

                                -->
                                <div id="overview" class="tab-pane active" role="tabpanel">
                                    <h4>Informações Pessoais</h4><br>

                                    <fieldset id="infoPessoal">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="nomeForm">Nome</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="nome" id="nomeForm" onkeypress="return Onlychars(event)" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="sobrenomeForm">Sobreome</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="sobrenome" id="sobrenomeForm" onkeypress="return Onlychars(event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="profileLastName">Sexo</label>
                                            <div class="col-md-8">
                                                <label><input type="radio" name="gender" id="radioM" id="M" value="m" style="margin-top: 10px; margin-left: 15px;" onclick="return exibir_reservista()"> <i class="fa fa-male" style="font-size: 20px;"> Masculino</i></label>
                                                <label><input type="radio" name="gender" id="radioF" id="F" value="f" style="margin-top: 10px; margin-left: 15px;" onclick="return esconder_reservista()"> <i class="fa fa-female" style="font-size: 20px;"> Feminino</i> </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="telefone">Telefone</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone" id="telefone" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="nascimento">Nascimento</label>
                                            <div class="col-md-8">
                                                <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" id="nascimento" max=<?php echo date('Y-m-d'); ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="pai">Nome do pai</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="nome_pai" id="pai" onkeypress="return Onlychars(event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="mae">Nome da mãe</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="nome_mae" id="mae" onkeypress="return Onlychars(event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="sangue">Tipo sanguíneo</label>
                                            <div class="col-md-6">
                                                <select class="form-control input-lg mb-md" name="sangue" id="sangue">
                                                    <option selected disabled value="">Selecionar</option>
                                                    <option id="sanque_ap" value="A+">A+</option>
                                                    <option id="sanque_an"  value="A-">A-</option>
                                                    <option id="sanque_bp"  value="B+">B+</option>
                                                    <option id="sanque_bn"  value="B-">B-</option>
                                                    <option id="sanque_op"  value="O+">O+</option>
                                                    <option id="sanque_on"  value="O-">O-</option>
                                                    <option id="sanque_abp"  value="AB+">AB+</option>
                                                    <option id="sanque_abn"  value="AB-">AB-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group center">
                                            <button type="button" class="btn btn-primary" id="botaoEditar_infoPessoal" onclick="switchForm('infoPessoal')">Editar</button>
                                            <input type="submit" class="btn btn-primary" disabled="true" value="Salvar" id="botaoSalvar_infoPessoal" onclick="submitForm('infoPessoal')">
                                        </div>

                                    </fieldset>

                                    <h4>Endereço</h4><br>

                                    <fieldset id="formEndereco">
                                        <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                        <input type="hidden" name="metodo" value="alterarEndereco">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="cep">CEP</label>
                                            <div class="col-md-8">
                                                <input type="text" name="cep" value="" size="10" onblur="pesquisacep(this.value);" class="form-control" id="cep" maxlength="9" placeholder="Ex: 22222-222" onkeypress="return Onlynumbers(event)" onkeyup="mascara('#####-###',this,event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="uf">Estado</label>
                                            <div class="col-md-8">
                                                <input type="text" name="uf" size="60" class="form-control" id="uf">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="cidade">Cidade</label>
                                            <div class="col-md-8">
                                                <input type="text" size="40" class="form-control" name="cidade" id="cidade">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="bairro">Bairro</label>
                                            <div class="col-md-8">
                                                <input type="text" name="bairro" size="40" class="form-control" id="bairro">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="rua">Logradouro</label>
                                            <div class="col-md-8">
                                                <input type="text" name="rua" size="2" class="form-control" id="rua">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="profileCompany">Número residencial</label>
                                            <div class="col-md-4">
                                                <input type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" name="numero_residencia" id="numero_residencia">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Não possuo número
                                                    <input type="checkbox" id="numResidencial" name="naoPossuiNumeroResidencial" style="margin-left: 4px" onclick="return numero_residencial()">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="profileCompany">Complemento</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="complemento" id="complemento" id="profileCompany">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="ibge">IBGE</label>
                                            <div class="col-md-8">
                                                <input type="text" size="8" name="ibge" class="form-control" id="ibge">
                                            </div>
                                        </div>
                                        <div class="form-group center">
                                            <button type="button" class="btn btn-primary" id="botaoEditar_formEndereco" onclick="switchForm('formEndereco')">Editar</button>
                                            <input type="submit" class="btn btn-primary" disabled="true" value="Salvar" id="botaoSalvar_formEndereco" onclick="submitForm('formEndereco')">
                                        </div>

                                    </fieldset>

                                    <h4>Documentações</h4>
                                    <h4>Outros</h4>
                                </div>


                                <!-- 
                                    Aba de documentos do dependente

                                -->

                                <div id="documentos" class="tab-pane" role="tabpanel">
                                    <h4>Documentos</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- end: page -->
    </section>
    </div>
    </section>

    <script>
        function pesquisacep(valor) {
        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('uf').value = "...";
            document.getElementById('ibge').value = "...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

            } //end if.
            else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }

        };
    </script>

    <!-- Vendor -->
    <script src="../assets/vendor/select2/select2.js"></script>
    <script src="../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
    <script src="../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
    <script src="../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="../assets/javascripts/theme.js"></script>

    <!-- Theme Custom -->
    <script src="../assets/javascripts/theme.custom.js"></script>

    <!-- Theme Initialization Files -->
    <script src="../assets/javascripts/theme.init.js"></script>


    <!-- Examples -->
    <script src="../assets/javascripts/tables/examples.datatables.default.js"></script>
    <script src="../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
    <script src="../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
</body>

</html>