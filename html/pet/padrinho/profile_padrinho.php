<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();

include_once ROOT."/dao/Conexao.php";

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
include_once ROOT.'/dao/Conexao.php';
include_once ROOT.'/dao/pet/padrinho/PadrinhoDAO.php';
include_once ROOT.'/dao/PermissaoDAO.php';
require_once ROOT.'/classes/Util.php';
require_once ROOT.'/permissao/permissao.php';
require_once ROOT.'/personalizacao_display.php';
require_once ROOT.'/geral/msg.php';

// Criar objetos das classes de controle
$padrinhos = new PadrinhoControle;
$padrinhos->listarCpf();  // Listar todos os padrinhos

$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<!doctype html>
<html class="fixed">

<head>
  <!-- Basic -->
  <meta charset="UTF-8">
  <title>Perfil Padrinho</title>
  <meta name="keywords" content="HTML5 Admin Template" />
  <meta name="description" content="Porto Admin - Responsive HTML5 Template">
  <meta name="author" content="okler.net">
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <!-- Web Fonts  -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
  <!-- <link rel="icon" href=" <?php  //display_campo("Logo", 'file'); ?>" type="image/x-icon" id="logo-icon">  -->
  <!-- Vendor CSS -->
  <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../../../assets/vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
  <link rel="stylesheet" href="../../../assets/vendor/magnific-popup/magnific-popup.css" />
  <link rel="stylesheet" href="../../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
  <!-- Theme CSS -->
  <link rel="stylesheet" href="../../../assets/stylesheets/theme.css" />
  <!-- Skin CSS -->
  <link rel="stylesheet" href="../../../assets/stylesheets/skins/default.css" />
  <!-- Theme Custom CSS -->
  <link rel="stylesheet" href="../../../assets/stylesheets/theme-custom.css">
  <link rel="stylesheet" href="../../../css/profile-theme.css" />
  <!-- Head Libs -->
  <script src="../../../assets/vendor/modernizr/modernizr.js"></script>
  <script src="../../../Functions/onlyNumbers.js"></script>
  <script src="../../../Functions/onlyChars.js"></script>
  <script src="../../../Functions/mascara.js"></script>
  <script src="../../../Functions/lista.js"></script>
  <script src="<?php echo WWW; ?>Functions/testaCPF.js"></script>

  <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../../../assets/vendor/magnific-popup/magnific-popup.css" />
  <link rel="stylesheet" href="../../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
  <!-- <link rel="icon" href=" <?php  //display_campo("Logo", 'file'); ?>" type="image/x-icon" id="logo-icon">  -->
  <!-- Specific Page Vendor CSS -->
  <link rel="stylesheet" href="../../../assets/vendor/select2/select2.css" />
  <link rel="stylesheet" href="../../../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
  <!-- Theme CSS -->
  <link rel="stylesheet" href="../../../assets/stylesheets/theme.css" />
  <!-- Skin CSS -->
  <link rel="stylesheet" href="../../../assets/stylesheets/skins/default.css" />
  <!-- Theme Custom CSS -->
  <link rel="stylesheet" href="../../../assets/stylesheets/theme-custom.css">
  <!-- Head Libs -->
  <script src="../../../assets/vendor/modernizr/modernizr.js"></script>
  <!-- Vendor -->
  <script src="../../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
  <script src="../../../assets/vendor/bootstrap/js/bootstrap.js"></script>
  <script src="../../../assets/vendor/nanoscroller/nanoscroller.js"></script>
  <script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="../../../assets/vendor/magnific-popup/magnific-popup.js"></script>
  <script src="../../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
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
  <!-- jquery functions -->
  <script>
    function editar_informacoes_pessoais() {
      $("#nomeForm").prop('disabled', false);
      $("#sobrenomeForm").prop('disabled', false);
      $("#radioM").prop('disabled', false);
      $("#radioF").prop('disabled', false);
      $("#telefone").prop('disabled', false);
      $("#nascimento").prop('disabled', false);
      $("#botaoEditarIP").html('Cancelar');
      $("#botaoSalvarIP").prop('disabled', false);
      $("#botaoEditarIP").removeAttr('onclick');
      $("#botaoEditarIP").attr('onclick', "return cancelar_informacoes_pessoais()");
    }

    function cancelar_informacoes_pessoais() {
      $("#nomeForm").prop('disabled', true);
      $("#sobrenomeForm").prop('disabled', true);
      $("#radioM").prop('disabled', true);
      $("#radioF").prop('disabled', true);
      $("#telefone").prop('disabled', true);
      $("#nascimento").prop('disabled', true);
      $("#botaoEditarIP").html('Editar');
      $("#botaoSalvarIP").prop('disabled', true);
      $("#botaoEditarIP").removeAttr('onclick');
      $("#botaoEditarIP").attr('onclick', "return editar_informacoes_pessoais()");
    }

    function editar_endereco() {
      $("#cep").prop('disabled', false);
      $("#uf").prop('disabled', false);
      $("#cidade").prop('disabled', false);
      $("#bairro").prop('disabled', false);
      $("#rua").prop('disabled', false);
      $("#complemento").prop('disabled', false);
      $("#ibge").prop('disabled', false);
      $("#numResidencial").prop('disabled', false);
      if ($('#numResidencial').is(':checked')) {
        $("#numero_residencia").prop('disabled', true);
      } else {
        $("#numero_residencia").prop('disabled', false);
      }
      $("#botaoEditarEndereco").html('Cancelar');
      $("#botaoSalvarEndereco").prop('disabled', false);
      $("#botaoEditarEndereco").removeAttr('onclick');
      $("#botaoEditarEndereco").attr('onclick', "return cancelar_endereco()");
    }

    function cancelar_endereco() {
      $("#cep").prop('disabled', true);
      $("#uf").prop('disabled', true);
      $("#cidade").prop('disabled', true);
      $("#bairro").prop('disabled', true);
      $("#rua").prop('disabled', true);
      $("#complemento").prop('disabled', true);
      $("#ibge").prop('disabled', true);
      $("#numResidencial").prop('disabled', true);
      $("#numero_residencia").prop('disabled', true);
      $("#botaoEditarEndereco").html('Editar');
      $("#botaoSalvarEndereco").prop('disabled', true);
      $("#botaoEditarEndereco").removeAttr('onclick');
      $("#botaoEditarEndereco").attr('onclick', "return editar_endereco()");
    }

    function editar_documentacao() {
      $("#cpf").prop('disabled', true);
      alert("O cpf não pode ser editado!");
      $("#botaoEditarDocumentacao").html('Cancelar');
      $("#botaoSalvarDocumentacao").prop('disabled', false);
      $("#botaoEditarDocumentacao").removeAttr('onclick');
      $("#botaoEditarDocumentacao").attr('onclick', "return cancelar_documentacao()");
    }

    function cancelar_documentacao() {
      $("#cpf").prop('disabled', true);
      $("#botaoEditarDocumentacao").html('Editar');
      $("#botaoSalvarDocumentacao").prop('disabled', true);
      $("#botaoEditarDocumentacao").removeAttr('onclick');
      $("#botaoEditarDocumentacao").attr('onclick', "return editar_documentacao()");
    }

    function alterardate(data) {
      var date = data.split("/")
      return date[2] + "-" + date[1] + "-" + date[0];
    }
    $(function() {
      var padrinho = <?= $func ?>;
      $.each(padrinho, function(i, item) {
        //Informações pessoais
        $("#nomeForm").val(item.nome).prop('disabled', true);
        $("#sobrenomeForm").val(item.sobrenome).prop('disabled', true);
        if (item.sexo == "m") {
          $("#radioM").prop('checked', true).prop('disabled', true);
          $("#radioF").prop('checked', false).prop('disabled', true);
          $("#reservista1").show();
          $("#reservista2").show();
        } else if (item.sexo == "f") {
          $("#radioM").prop('checked', false).prop('disabled', true)
          $("#radioF").prop('checked', true).prop('disabled', true);
        }
        $("#telefone").val(item.telefone).prop('disabled', true);
        $("#nascimento").val(alterardate(item.data_nascimento)).prop('disabled', true);
        //Endereço
        $("#cep").val(item.cep).prop('disabled', true);
        $("#uf").val(item.estado).prop('disabled', true);
        $("#cidade").val(item.cidade).prop('disabled', true);
        $("#bairro").val(item.bairro).prop('disabled', true);
        $("#rua").val(item.logradouro).prop('disabled', true);
        $("#complemento").val(item.complemento).prop('disabled', true);
        $("#ibge").val(item.ibge).prop('disabled', true);
        if (item.numero_endereco == 'N?o possui' || item.numero_endereco == null) {
          $("#numResidencial").prop('checked', true).prop('disabled', true);
          $("#numero_residencia").prop('disabled', true);
        } else {
          $("#numero_residencia").val(item.numero_endereco).prop('disabled', true);
          $("#numResidencial").prop('disabled', true);
        }
        //Documentação
        var cpf = item.cpf;
        $("#cpf").val(cpf).prop('disabled', true);
      })
    });
  </script>
  <script type="text/javascript">
    function numero_residencial() {
      if ($("#numResidencial").prop('checked')) {
        $("#numero_residencia").val('');
        document.getElementById("numero_residencia").disabled = true;
      } else {
        document.getElementById("numero_residencia").disabled = false;
      }
    }

    function limpa_formulário_cep() {
      //Limpa valores do formulário de cep.
      document.getElementById('rua').value = ("");
      document.getElementById('bairro').value = ("");
      document.getElementById('cidade').value = ("");
      document.getElementById('uf').value = ("");
      document.getElementById('ibge').value = ("");
    }

    function meu_callback(conteudo) {
      if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('uf').value = (conteudo.uf);
        document.getElementById('ibge').value = (conteudo.ibge);
      } //end if.
      else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
      }
    }

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

    function validarCPF(strCPF) {
      if (!testaCPF(strCPF)) {
        $('#cpfInvalido').show();
        document.getElementById("enviarEditar").disabled = true;
      } else {
        $('#cpfInvalido').hide();
        document.getElementById("enviarEditar").disabled = false;
      }
    }
  </script>
  <script language="JavaScript">
    var numValidos = "0123456789-()";
    var num1invalido = "78";
    var i;

    function validarTelefone() {
      //Verificando quantos dígitos existem no campo, para controlarmos o looping;
      digitos = document.form1.telefone.value.length;
      for (i = 0; i < digitos; i++) {
        if (numValidos.indexOf(document.form1.telefone.value.charAt(i), 0) == -1) {
          alert("Apenas números são permitidos no campo Telefone!");
          document.form1.telefone.select();
          return false;
        }
        if (i == 0) {
          if (num1invalido.indexOf(document.form1.telefone.value.charAt(i), 0) != -1) {
            alert("Número de telefone inválido!");
            document.form1.telefone.select();
            return false;
          }
        }
      }
    }
    $(function() {
      $("#header").load("../header.php");
      $(".menuu").load("../menu.php");
    });

    function gerarSituacao() {
      url = '../../../dao/exibir_situacao.php';
      $.ajax({
        data: '',
        type: "POST",
        url: url,
        async: true,
        success: function(response) {
          var situacoes = response;
          $('#situacao').empty();
          $('#situacao').append('<option selected disabled>Selecionar</option>');
          $.each(situacoes, function(i, item) {
            $('#situacao').append('<option value="' + item.id_situacao + '">' + item.situacoes + '</option>');
          });
        },
        dataType: 'json'
      });
    }

    function adicionar_situacao() {
      url = '../../../dao/exibir_situacao.php';
      var situacao = window.prompt("Cadastre uma Nova Situação:");
      if (!situacao) {
        return
      }
      situacao = situacao.trim();
      if (situacao == '') {
        return
      }
      data = 'situacao=' + situacao;
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response) {
          gerarSituacao();
        },
        dataType: 'text'
      })
    }

    function gerarCargo() {
      url = '../../../dao/exibir_situacao.php';
      $.ajax({
        data: '',
        type: "POST",
        url: url,
        success: function(response) {
          var cargo = response;
          $('#cargo').empty();
          $('#cargo').append('<option selected disabled>Selecionar</option>');
          $.each(cargo, function(i, item) {
            $('#cargo').append('<option value="' + item.id_cargo + '">' + item.cargo + '</option>');
          });
        },
        dataType: 'json'
      });
    }

    function adicionar_cargo() {
      url = '../../../dao/exibir_situacao.php';
      var cargo = window.prompt("Cadastre um Novo Cargo:");
      if (!cargo) {
        return
      }
      situacao = cargo.trim();
      if (cargo == '') {
        return
      }
      data = {
        nomeClasse : 'CargoControle',
        metodo: 'incluir',
        cargo : cargo
      };
      console.log(data);
      $.ajax({
        type: "POST",
        url: url,
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function(response) {
            gerarCargo();
        },
        dataType: 'text'
    });
    }
  </script>
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
                <a href="../home.php">
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
                <div class="widget-toggle-expand mb-md">
                  <div class="widget-header">
                    <div class="widget-content-expanded">
                      <ul class="simple-todo-list"></ul>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
          <div class="col-md-8 col-lg-8">
            <div class="tabs">
              <ul class="nav nav-tabs tabs-primary">
                <li class="active">
                  <a href="#overview" data-toggle="tab">Informações Pessoais</a>
                </li>
                <li>
                  <a href="#endereco" data-toggle="tab">Endereço</a>
                </li>
                <li>
                  <a href="#documentos" data-toggle="tab">Documentação</a>
                </li>
              </ul>
              <div class="tab-content">
                <!--Aba de Informações Pessoais-->
                <div id="overview" class="tab-pane active">
                  <form class="form-horizontal" method="post" action="../../../controle/control.php">
                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                    <input type="hidden" name="metodo" value="alterarInfPessoal">
                    <h4 class="mb-xlg">Informações Pessoais</h4>
                    <fieldset>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">Nome</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="nome" id="nomeForm" onkeypress="return Onlychars(event)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">Sobrenome</label>
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
                        <label class="col-md-3 control-label" for="profileCompany">Telefone</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone" id="telefone" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileCompany">Nascimento</label>
                        <div class="col-md-8">
                          <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" id="nascimento" max=<?php echo date('Y-m-d'); ?>>
                        </div>
                      </div>
                      <div class="form-group">
                      <input type="hidden" name="id_padrinho" value=<?php echo $_GET['id_pessoa'] ?>>
                      <button type="button" class="btn btn-primary" id="botaoEditarIP" onclick="return editar_informacoes_pessoais()">Editar</button>
                      <input type="submit" class="btn btn-primary" disabled="true" value="Salvar" id="botaoSalvarIP">
                    </fieldset>
                  </form><br>
                  <div class="panel-footer">
                    <div class="row">
                      <div class="col-md-9 col-md-offset-3">
                        <!-- <button id="excluir" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exclusao">Demitir</button> -->
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="exclusao" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" aba-dismiss="modal">×</button>
                          <h3>Excluir um </h3>
                        </div>
                        <div class="modal-body">
                          <p> Tem certeza que deseja excluir esse padrinho? Essa ação não poderá ser desfeita e todas as informações referentes a esse padrinho serão perdidas!</p>
                          <a href="../../../controle/control.php?metodo=excluir&nomeClasse=PadrinhoControle&id_pessoa=<?php echo $_GET['id_pessoa']; ?>"><button button type="button" class="btn btn-success">Confirmar</button></a>
                          <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Outros-->
                <script>
                  function formatPIS(input) {
                    let value = input.value.replace(/\D/g, '');
                    if (value.length > 11) value = value.substring(0, 11);
                    input.value = value.replace(/(\d{3})(\d{5})(\d{2})(\d{1})/, '$1.$2.$3-$4');
                  }

                  function formatCTPS(input) {
                    let value = input.value.replace(/\D/g, '');
                    if (value.length > 11) value = value.substring(0, 11);
                    input.value = value.replace(/(\d{7})(\d{4})/, '$1/$2');
                  }
                </script>
                <!-- Aba de documentos do funcionário -->
                <div id="documentos" class="tab-pane">
                  <section class="panel">
                    <header class="panel-heading">
                      <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                      </div>
                      <h2 class="panel-title">Documentos</h2>
                    </header>
                    <div class="panel-body">
                      <!--Documentação-->
                      <hr class="dotted short">
                      <form class="form-horizontal" method="post" action="../../../controle/control.php">
                        <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                        <input type="hidden" name="metodo" value="alterarDocumentacao">
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="profileCompany">Número do CPF</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="profileCompany"></label>
                          <div class="col-md-6">
                            <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                          </div>
                        </div>
                        <input type="hidden" id="" name="id_padrinho" value=<?php echo $_GET['id_pessoa'] ?>>
                        <button type="button" class="btn btn-primary" id="botaoEditarDocumentacao" onclick="return editar_documentacao()">Editar</button>
                        <input id="botaoSalvarDocumentacao" type="submit" class="btn btn-primary" disabled="true" value="Salvar" onclick="funcao3()">
                      </form>
                    </div>
                  </section>
                </div>
                <!-- Aba endereço -->
                <div id="endereco" class="tab-pane">
                  <section class="panel">
                    <header class="panel-heading">
                      <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                      </div>
                      <h2 class="panel-title">Endereço</h2>
                    </header>
                    <div class="panel-body">
                      <!--Endereço-->
                      <hr class="dotted short">
                      <form class="form-horizontal" method="post" action="../../../controle/control.php">
                        <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                        <input type="hidden" name="metodo" value="alterarEndereco">
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="cep">CEP</label>
                          <div class="col-md-8">
                            <input type="text" name="cep" value="" size="10" onblur="pesquisacep(this.value);" class="form-control" id="cep" maxlength="9" placeholder="Ex: 22222-222" onkeydown="return Onlynumbers(event)" onkeyup="mascara('#####-###',this,event)">
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
                          <input type="hidden" name="id_padrinho" value=<?php echo $_GET['id_pessoa'] ?>>
                          <button type="button" class="btn btn-primary" id="botaoEditarEndereco" onclick="return editar_endereco()">Editar</button>
                          <input id="botaoSalvarEndereco" type="submit" class="btn btn-primary" disabled="true" value="Salvar" onclick="funcao3()">
                        </div>
                    </div>
                    </form>
                </div>
      </section>
    </div>
    <!-- end: page -->
    </div>
    </div>
    </div>
  </section>
  </div>
  </section>
  <!-- Vendor -->
  <script src="../../../assets/vendor/select2/select2.js"></script>
  <script src="../../../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
  <script src="../../../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
  <script src="../../../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
  <script src="../../../assets/vendor/nanoscroller/nanoscroller.js"></script>
  <!-- Theme Base, Components and Settings -->
  <script src="../../../assets/javascripts/theme.js"></script>
  <!-- Theme Custom -->
  <script src="../../../assets/javascripts/theme.custom.js"></script>
  <!-- Metodo Post -->
  <script src="../geral/post.js"></script>
  <!-- Theme Initialization Files -->
  <script src="../../../assets/javascripts/theme.init.js"></script>
  <!-- Examples -->
  <script src="../../../assets/javascripts/tables/examples.datatables.default.js"></script>
  <script src="../../../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
  <script src="../../../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
  <script>
    function submitForm(idForm, callback = function() {
      return true;
    }) {
      var data = getFormPostParams(idForm);
      console.log(data);
      var url;
      var data_nova;
      switch (idForm) {
        case "formRemuneracao":
          url = "remuneracao.php";
          data_nova = "id_tipo=" + data[0] + "&valor=" + data[1] + "&inicio=" + data[2] + "&fim=" + data[3] + "&action=remuneracao_adicionar&id_padrinho=" + data[4];
          break;
        case "formInfoAdicional":
          url = "informacao_adicional.php";
          data_nova = "id_descricao=" + data[0] + "&dados=" + data[1] + "&action=adicionar&id_pessoa=" + data[3];
          listarInfoAdicional(data);
          break;
        default:
          console.warn("Não existe nenhuma URL registrada para o formulário com o seguinte id: " + idForm);
          return false;
          break;
      }
      if (!data) {
        window.alert("Preencha todos os campos obrigatórios antes de prosseguir!");
        return false;
      }
      post(url, data_nova, callback);
      console.log(idForm + " => " + data + " | ", callback);
      return true;
    }

    function funcao3() {
      var idpadrinho = <?php echo $_GET['id_pessoa']; ?>;
      var cpfs = <?php echo $_SESSION['cpf_pessoa']; ?>;
      var cpf_padrinho= $("#cpf").val();
      var cpf_padrinho_correto = cpf_padrinho.replace(".", "");
      var cpf_padrinho_correto1 = cpf_padrinho_correto.replace(".", "");
      var cpf_padrinho_correto2 = cpf_padrinho_correto1.replace(".", "");
      var cpf_padrinho_correto3 = cpf_padrinho_correto2.replace("-", "");
      var apoio = 0;
      var cpfs1 = <?php echo $_SESSION['cpf_atendido']; ?>;
      $.each(cpfs, function(i, item) {
        if (item.cpf == cpf_padrinho_correto3 && item.id != idfunc) {
          alert("Alteração não realizada! O CPF informado já está cadastrado no sistema");
          apoio = 1;
        }
      });
      $.each(cpfs1, function(i, item) {
        if (item.cpf == cpf_padrinho_correto3) {
          alert("Cadastro não realizado! O CPF informado já está cadastrado no sistema");
          apoio = 1;
        }
      });
      if (apoio == 0) {
        alert("Editado com sucesso!");
      }
    }
  </script>
  <!-- JavaScript Custom -->
  <script src="../geral/post.js"></script>
  <script src="../geral/formulario.js"></script>
  <script>
    var formState = [];

    function switchButton(idForm) {
      if (!formState[idForm]) {
        $("#botaoEditar_" + idForm).text("Editar").prop("class", "btn btn-primary");
      } else {
        $("#botaoEditar_" + idForm).text("Cancelar").prop("class", "btn btn-danger");
      }
    }

    function switchForm(idForm, setState = null) {
      if (setState !== null) {
        formState[idForm] = !setState;
      }
      if (formState[idForm]) {
        formState[idForm] = false;
        disableForm(idForm);
      } else {
        formState[idForm] = true;
        enableForm(idForm);
      }
      switchButton(idForm);
    }
    switchForm("editar_cargaHoraria", false)
  </script>
  <div align="right">
    <iframe src="https://www.wegia.org/software/footer/padrinho.html" width="200" height="60" style="border:none;"></iframe>
  </div>
</body>

</html>