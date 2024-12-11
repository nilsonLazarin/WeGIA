<?php

include_once("../../../dao/Conexao.php");
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location: ../../index.php");
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

// Requerimentos essenciais
require_once ROOT . "/controle/PadrinhoControle.php";
require_once ROOT . "/classes/pet/padrinho/Padrinho.php";
require_once ROOT . "/html/personalizacao_display.php";
require_once ROOT . "/dao/Conexao.php";

// Inicialização e chamada de métodos
$padrinhoControle = new PadrinhoControle();
$listaCPF = $padrinhoControle->listarCpf();

// Obtenção de dados do padrinho pelo CPF
$cpf = $_GET['cpf'] ?? null;
if ($cpf) {
    $padrinhoDAO = new PadrinhoDAO();
    $informacoesPadrinho = $padrinhoDAO->listarPessoaExistente($cpf);
}

// Definição de limites de datas
$dataNascimentoMaxima = Padrinho::getDataNascimentoMaxima();
$dataNascimentoMinima = Padrinho::getDataNascimentoMinima();


// Definição de limites de datas
$dataNascimentoMaxima = Padrinho::getDataNascimentoMaxima();
$dataNascimentoMinima = Padrinho::getDataNascimentoMinima();


?>
<!DOCTYPE html>
<html class="fixed">

<head>
  <!-- Basic -->
  <meta charset="UTF-8">
  <title>Cadastro de Padrinho</title>
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <!-- Web Fonts  -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../../../assets/vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
  <link rel="stylesheet" href="../../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
  

  <!-- Theme CSS -->
  <link rel="stylesheet" href="../../../assets/stylesheets/theme.css" />

  <!-- Skin CSS -->
  <link rel="stylesheet" href="../../../assets/stylesheets/skins/default.css" />

  <!-- Theme Custom CSS -->
  <link rel="stylesheet" href="../../../assets/stylesheets/theme-custom.css">

  <?php echo $informacoesPadrinho ?>; 
    
   

</head>

<body>
  <!-- start: header -->
  <div id="header"></div>
  <!-- end: header -->
  <div class="inner-wrapper">
    <!-- start: sidebar -->
    <aside id="sidebar-left" class="sidebar-left menuu"></aside>

    <section role="main" class="content-body">
      <header class="page-header">
        <h2>Cadastro</h2>
        <div class="right-wrapper pull-right">
          <ol class="breadcrumbs">
            <li>
              <a href="../home.php">
                <i class="fa fa-home"></i>
              </a>
            </li>
            <li><span>Cadastros</span></li>
            <li><span>Padrinhos</span></li>
          </ol>
          <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
        </div>
      </header>
      <!-- start: page -->
        <div class="col-md-8 col-lg-8">
          <div class="tabs">
            <ul class="nav nav-tabs tabs-primary">
              <li class="active">
                <a href="#overview" data-toggle="tab">Cadastro de Padrinhos</a>
              </li>
            </ul>
            <div class="tab-content">
              <div id="overview" class="tab-pane active">
                <form class="form-horizontal" method="GET" action="../../../controle/control.php">
                  <h4 class="mb-xlg">Informações Pessoais</h4>
                  <h5 class="obrig">Campos Obrigatórios(*)</h5>
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="profileFirstName">Nome<sup class="obrig">*</sup></label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="nome" id="profileFirstName" id="nome" onkeypress="return Onlychars(event)" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Sobrenome<sup class="obrig">*</sup></label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="sobrenome" id="sobrenome" onkeypress="return Onlychars(event)" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="profileLastName">Sexo<sup class="obrig">*</sup></label>
                    <div class="col-md-8">
                      <label><input type="radio" name="gender" id="radioM" id="M" value="m" style="margin-top: 10px; margin-left: 15px;" required><i class="fa fa-male" style="font-size: 20px;"></i></label>
                      <label><input type="radio" name="gender" id="radioF" id="F" value="f" style="margin-top: 10px; margin-left: 15px;" ><i class="fa fa-female" style="font-size: 20px;"></i> </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="telefone">Telefone<sup class="obrig">*</sup></label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone" id="telefone" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="profileCompany">Nascimento<sup class="obrig">*</sup></label>
                    <div class="col-md-8">
                      <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" id="nascimento" min="<?= $dataNascimentoMinima?>" max=<?= $dataNascimentoMaxima?> required>
                    </div>
                  </div>
                  <hr class="dotted short">
                  <h4 class="mb-xlg doch4">Documentação</h4>
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="cpf">Número do CPF<sup class="obrig">*</sup></label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="cpf" id="cpf" name="cpf" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##', this, event)" value="<?php
                                                                                                                                                                                                                                                                          if (isset($cpf) && !is_null(trim($cpf))) {
                                                                                                                                                                                                                                                                            echo $cpf;
                                                                                                                                                                                                                                                                          } ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="profileCompany"></label>
                    <div class="col-md-6">
                      <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                    </div>
                  </div>
                  <div class="panel-footer">
                    <div class="row">
                      <div class="col-md-9 col-md-offset-3">
                        <input type="hidden" name="nomeClasse" value="PadrinhoControle">
                        <input type="hidden" name="metodo" value="incluir">
                        <input id="enviar" type="submit" class="btn btn-primary" value="Salvar">
                        <input type="reset" class="btn btn-default">
                      </div>
                    </div>
                  </div>
                </form>
                <iframe name="frame"></iframe>
                <!-- end: page -->
    </section>
  </div>
  </section>
   <!-- <<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->

  <!-- JQuery Online -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- JQuery Local -->
  <script src="../../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="https://requirejs.org/docs/release/2.3.6/r.js"></script>
  <style type="text/css">
    .btn span.fa-check {
      opacity: 0;
    }

    .btn.active span.fa-check {
      opacity: 1;
    }

    .obrig {
      color: rgb(255, 0, 0);
    }

    iframe {
      display: none;
    }

    #display_image {

      min-height: 250px;
      margin: 0 auto;
      border: 1px solid black;
      background-position: center;
      background-size: cover;
      background-image: url("../../img/semfoto.png")
    }


    #display_image:after {

      content: "";
      display: block;
      padding-bottom: 100%;
    }
  </style>
  <script>
 
   $(function() {
      $("#header").load("../../header.php");
      $(".menuu").load("../../menu.php");
    });
    function funcao1() {
  
    var send = $("#enviar");
    var cpfs = <?php
        require_once ROOT . "/dao/pet/padrinho/PadrinhoDAO.php";
        $padrinhoDAO = new PadrinhoDAO();
        echo json_encode($padrinhoDAO->listarCPFPessoas());
    ?>;
    var cpfFuncionario = limparCPF($("#cpf").val());
    var apoio = 0;

    $.each(cpfs, function(i, item) {
        if (item.cpf === cpfFuncionario) {
            alert("Cadastro não realizado! O CPF informado já está cadastrado no sistema");
            apoio = 1;
            send.attr('disabled', 'disabled');
            return false; // Para sair do loop
        }
    });

    if (apoio === 0) {
        alert("Cadastrado com sucesso!");
    }

      
}


document.querySelector("#enviar").addEventListener("click" , validarPadrinho)

function validarPadrinho(ev) {
  ev.preventDefault() 

   if(validar()){
    var btn = $("#enviar");
    var cpfCadastrado = <?php
        echo json_encode($padrinhoDAO->listarCPFPessoas());
    ?>;
    var cpf = limparCPF($("#cpf").val());

    $.each(cpfCadastrado, function(i, item) {
        if (item.cpf === cpf) {
            alert("Cadastro não realizado! O CPF informado já está cadastrado no sistema");
            btn.attr('disabled', 'disabled');
            return false; // Para sair do loop
        }
    });
  
  }
}



function okDisplay() {
    document.getElementById("okButton").style.backgroundColor = "#0275d8"; // azul
    document.getElementById("okText").textContent = "Confirme o arquivo selecionado";
    $("#profileFirstName, #sobrenome, #telefone, #nascimento").prop('disabled', true);
}

function submitButtonStyle(_this) {
    _this.style.backgroundColor = "#5cb85c"; // verde
    document.getElementById("okText").textContent = "Arquivo confirmado";
    $("#profileFirstName, #sobrenome, #telefone, #nascimento").prop('disabled', false);
}

function limparCPF(cpf) {
    return cpf.replaceAll(".", "").replaceAll("-", "");
}

 function validar() {

  var nome = document.getElementById('profileFirstName').value;

  var sobrenome = document.getElementById('sobrenome').value;

  var sexo = document.querySelector('input[name="gender"]:checked')?.value;

  var telefone = document.getElementById('telefone').value;

  var dt_nasc = document.getElementById('nascimento').value;

  let dataNascimentoMaxima = "<?=$dataNascimentoMaxima?>";
  dataNascimentoMaxima = dataNascimentoMaxima.replaceAll('-', '');

  let dataNascimentoMinima = "<?=$dataNascimentoMinima?>";
  dataNascimentoMinima = dataNascimentoMinima.replaceAll('-', '');

  dt_nasc = dt_nasc.replaceAll('-', '');

  if (nome && sobrenome && sexo && telefone && dt_nasc) {
    alert("Cadastrado com sucesso!");
    
    return true
  }else{
    alert("Insira todas as informações!");
  }
   
  if(!validarTelefone()) {

    alert('Telefone invalido')
    return false;
  }
  if(dt_nasc > dataNascimentoMaxima){
    alert('Data de Nascimento inválida')
    return false;
  }

  if(dt_nasc < dataNascimentoMinima){
    alert('Data de Nascimento inválida')
    return false;
  }

 //cpf,$nome,$sobrenome,$sexo,$dataNascimento,$registroGeral,$orgaoEmissor,$dataExpedicao,$nomeMae,$nomePai,$tipoSanguineo,$senha,$telefone,$imagem,$cep,$estado,$cidade,$bairro,$logradouro,$numeroEndereco,$complemento,$ibge

}

function numero_residencial() {

  if ($("#numResidencial").prop('checked')) {

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
    document.getElementById("enviar").disabled = true;

  } else {
    $('#cpfInvalido').hide();

    document.getElementById("enviar").disabled = false;
  }
}
var numValidos = "0123456789-()";
    var num1invalido = "78";
    var i;
    let  telefone = document.getElementById('telefone');
    function validarTelefone() {
      console.log(telefone.value)
      //Verificando quantos dígitos existem no campo, para controlarmos o looping;
      digitos = telefone.value.length;

      for (i = 0; i < digitos; i++) {
        if (numValidos.indexOf(telefone.value.charAt(i), 0) == -1) {
          alert("Apenas números são permitidos no campo Telefone!");
          telefone.select();
          return false;
        }
        if (i == 0) {
          if (num1invalido.indexOf(telefone.value.charAt(i), 0) != -1) {
            alert("Número de telefone inválido!");
            telefone.select();
            return false;
          }
        }
      } return true
    }
   
  </script>

  <!-- Head Libs -->
  <script src="../../assets/vendor/modernizr/modernizr.js"></script>

  <!-- javascript functions -->
  <script src="../../../Functions/onlyNumbers.js"></script>
  <script src="../../../Functions/onlyChars.js"></script>
  <script src="../../../Functions/mascara.js"></script>
  <script src="../../../Functions/lista.js"></script>
  <script src="<?php echo WWW; ?>Functions/testaCPF.js"></script>

  <!-- Vendor -->
  <script src="../../../assets/vendor/jquery/jquery.js"></script>
  <script src="../../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
  <script src="../../../assets/vendor/bootstrap/js/bootstrap.js"></script>
  <script src="../../../assets/vendor/nanoscroller/nanoscroller.js"></script>
  <script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="../../../assets/vendor/magnific-popup/magnific-popup.js"></script>
  <script src="../../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

  <div align="right">
    <iframe src="https://www.wegia.org/software/footer/funcionario.html" width="200" height="60" style="border:none;"></iframe>
  </div>
  <script src="./script/cadastro_padrinho.js" type="module"></script>
</body>

</html>