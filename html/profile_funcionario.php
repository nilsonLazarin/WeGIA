<?php
session_start();

require_once "../dao/Conexao.php";
$pdo = Conexao::connect();
if (!isset($_SESSION['usuario'])) {
  header("Location: ../index.php");
} else if (!isset($_SESSION['funcionario'])) {
  $id_funcionario = $_GET['id_funcionario'];
  header('Location: ../controle/control.php?metodo=listarUm&nomeClasse=FuncionarioControle&nextPage=../html/profile_funcionario.php?id_funcionario=' . $id_funcionario . '&id_funcionario=' . $id_funcionario);
} else if (!isset($_SESSION['beneficio'])) {
  $id_funcionario = $_GET['id_funcionario'];
  header('Location: ../controle/control.php?metodo=listarBeneficio&nomeClasse=FuncionarioControle&nextPage=../html/profile_funcionario.php?id_funcionario=' . $id_funcionario . '&id_funcionario=' . $id_funcionario);
} else if (!isset($_SESSION['epi'])) {
  $id_funcionario = $_GET['id_funcionario'];
  header('Location: ../controle/control.php?metodo=listarEpi&nomeClasse=FuncionarioControle&nextPage=../html/profile_funcionario.php?id_funcionario=' . $id_funcionario . '&id_funcionario=' . $id_funcionario);
} else {

  $func = $_SESSION['funcionario'];
  $bene = $_SESSION['beneficio'];
  $epi = $_SESSION['epi'];
  unset($_SESSION['funcionario']);
  unset($_SESSION['beneficio']);
  unset($_SESSION['epi']);

  // Adiciona Descrição de escala e tipo
  $func = json_decode($func);
  if ($func) {
    $func = $func[0];
    if ($func->tipo) {
      $func->tipo_descricao = $pdo->query("SELECT descricao FROM tipo_quadro_horario WHERE id_tipo=" . $func->tipo)->fetch(PDO::FETCH_ASSOC)['descricao'];
    }
    if ($func->escala) {
      $func->escala_descricao = $pdo->query("SELECT descricao FROM escala_quadro_horario WHERE id_escala=" . $func->escala)->fetch(PDO::FETCH_ASSOC)['descricao'];
    }
    $func = json_encode([$func]);
  }
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

$docfuncional = $pdo->query("SELECT * FROM funcionario_docs f JOIN funcionario_docfuncional docf ON f.id_docfuncional = docf.id_docfuncional WHERE id_funcionario = ".$_GET['id_funcionario']);
$docfuncional = $docfuncional->fetchAll(PDO::FETCH_ASSOC);
$docfuncional = json_encode($docfuncional);

$dependente = $pdo->query("SELECT 
fdep.id_dependente AS id_dependente, p.nome AS nome, p.cpf AS cpf, par.descricao AS parentesco
FROM funcionario_dependentes fdep
LEFT JOIN funcionario f ON f.id_funcionario = fdep.id_funcionario
LEFT JOIN pessoa p ON p.id_pessoa = fdep.id_pessoa
LEFT JOIN funcionario_dependente_parentesco par ON par.id_parentesco = fdep.id_parentesco
WHERE fdep.id_funcionario = ".$_GET['id_funcionario']);
$dependente = $dependente->fetchAll(PDO::FETCH_ASSOC);
$dependente = json_encode($dependente);

?>
<!doctype html>
<html class="fixed">

<head>
  <!-- Basic -->
  <meta charset="UTF-8">
  <title>Perfil funcionário</title>
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
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
  <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
  <script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
  <!-- Theme CSS -->
  <link rel="stylesheet" href="../assets/stylesheets/theme.css" />
  <!-- Skin CSS -->
  <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
  <!-- Theme Custom CSS -->
  <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
  <link rel="stylesheet" href="../css/profile-theme.css" />
  <!-- Head Libs -->
  <script src="../assets/vendor/modernizr/modernizr.js"></script>
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
      $("#pai").prop('disabled', false);
      $("#mae").prop('disabled', false);
      $("#sangue").prop('disabled', false);

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
      $("#pai").prop('disabled', true);
      $("#mae").prop('disabled', true);
      $("#sangue").prop('disabled', true);

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

      $("#rg").prop('disabled', false);
      $("#orgao_emissor").prop('disabled', false);
      $("#data_expedicao").prop('disabled', false);
      $("#cpf").prop('disabled', false);
      $("#data_admissao").prop('disabled', false);

      $("#botaoEditarDocumentacao").html('Cancelar');
      $("#botaoSalvarDocumentacao").prop('disabled', false);
      $("#botaoEditarDocumentacao").removeAttr('onclick');
      $("#botaoEditarDocumentacao").attr('onclick', "return cancelar_documentacao()");

    }

    function cancelar_documentacao() {

      $("#rg").prop('disabled', true);
      $("#orgao_emissor").prop('disabled', true);
      $("#data_expedicao").prop('disabled', true);
      $("#cpf").prop('disabled', true);
      $("#data_admissao").prop('disabled', true);

      $("#botaoEditarDocumentacao").html('Editar');
      $("#botaoSalvarDocumentacao").prop('disabled', true);
      $("#botaoEditarDocumentacao").removeAttr('onclick');
      $("#botaoEditarDocumentacao").attr('onclick', "return editar_documentacao()");

    }

    function editar_outros() {
      $("#pis").prop('disabled', false);
      $("#ctps").prop('disabled', false);
      $("#uf_ctps").prop('disabled', false);
      $("#zona_eleitoral").prop('disabled', false);
      $("#titulo_eleitor").prop('disabled', false);
      $("#secao_titulo_eleitor").prop('disabled', false);
      $("#certificado_reservista_numero").prop('disabled', false);
      $("#certificado_reservista_serie").prop('disabled', false);
      $("#situacao").prop('disabled', false);
      $("#cargo").prop('disabled', false);

      $("#botaoEditarOutros").html('Cancelar');
      $("#botaoSalvarOutros").prop('disabled', false);
      $("#botaoEditarOutros").removeAttr('onclick');
      $("#botaoEditarOutros").attr('onclick', "return cancelar_outros()");

    }

    function cancelar_outros() {

      $("#pis").prop('disabled', true);
      $("#ctps").prop('disabled', true);
      $("#uf_ctps").prop('disabled', true);
      $("#zona_eleitoral").prop('disabled', true);
      $("#titulo_eleitor").prop('disabled', true);
      $("#secao_titulo_eleitor").prop('disabled', true);
      $("#certificado_reservista_numero").prop('disabled', true);
      $("#certificado_reservista_serie").prop('disabled', true);
      $("#situacao").prop('disabled', true);
      $("#cargo").prop('disabled', true);

      $("#botaoEditarOutros").html('Editar');
      $("#botaoSalvarOutros").prop('disabled', true);
      $("#botaoEditarOutros").removeAttr('onclick');
      $("#botaoEditarOutros").attr('onclick', "return editar_outros()");

    }

    function clicar_epi(id) {
      window.location.href = "../html/editar_epi.php?id_funcionario=" + id;
    }

    function clicar_beneficio(id) {
      window.location.href = "../html/editar_beneficio.php?id_funcionario=" + id;
    }

    function excluir_beneficio(id) {
      window.location.href = "../controle/control.php?metodo=excluirBeneficio&nomeClasse=FuncionarioControle&id_beneficiados=" + id;
    }

    function excluir_epi(id) {
      window.location.href = "../controle/control.php?metodo=excluirEpi&nomeClasse=FuncionarioControle&id_pessoa_epi=" + id;
    }

    function alterardate(data) {
      var date = data.split("/")
      return date[2] + "-" + date[1] + "-" + date[0];
    }

    $(function() {

      var funcionario = <?= $func ?>;
      $.each(funcionario, function(i, item) {
        //Informações pessoais
        // console.log(funcionario)
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

        // if(item.imagem!=""){
        //   $("#imagem").attr("src","data:image/gif;base64,"+item.imagem);
        // }
        // else{
        //   $("#imagem").attr("src", "../img/semfoto.png");
        // }

        $("#telefone").val(item.telefone).prop('disabled', true);
        $("#nascimento").val(alterardate(item.data_nascimento)).prop('disabled', true);
        $("#pai").val(item.nome_pai).prop('disabled', true);
        $("#mae").val(item.nome_mae).prop('disabled', true);
        $("#sangue").val(item.tipo_sanguineo).prop('disabled', true);

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
        var cpf = item.cpf.substr(0, 3) + "." + item.cpf.substr(3, 3) + "." + item.cpf.substr(6, 3) + "-" + item.cpf.substr(9, 2);

        $("#rg").val(item.registro_geral).prop('disabled', true);
        $("#orgao_emissor").val(item.orgao_emissor).prop('disabled', true);
        $("#data_expedicao").val(alterardate(item.data_expedicao)).prop('disabled', true);
        $("#cpf").val(cpf).prop('disabled', true);
        $("#data_admissao").val(alterardate(item.data_admissao)).prop('disabled', true);

        //Outros
        $("#pis").val(item.pis).prop('disabled', true);
        $("#ctps").val(item.ctps).prop('disabled', true);
        $("#uf_ctps").val(item.uf_ctps).prop('disabled', true);
        $("#zona_eleitoral").val(item.zona).prop('disabled', true);
        $("#titulo_eleitor").val(item.numero_titulo).prop('disabled', true);
        $("#secao_titulo_eleitor").val(item.secao).prop('disabled', true);
        $("#certificado_reservista_numero").val(item.certificado_reservista_numero).prop('disabled', true);
        $("#certificado_reservista_serie").val(item.certificado_reservista_serie).prop('disabled', true);
        $("#situacao").val(item.id_situacao).prop('disabled', true);
        $("#cargo").val(item.id_cargo).prop('disabled', true);

        //CARGA HORÁRIA


        // $("#escala").text("Escala: " + (item.escala_descricao || "Sem informação"));
        // $("#tipo").text("Tipo: " + (item.tipo_descricao || "Sem informação"));
        $("#dias_trabalhados").text("Dias trabalhados: " + (item.dias_trabalhados || "Sem informação"));
        if (item.dias_trabalhados == "Plantão") {
          $("#dias_trabalhados").text("Dias trabalhados: " + (item.dias_trabalhados || "Sem informação") + " 12/36");
        }
        $("#dias_folga").text("Dias de folga: " + (item.folga || "Sem informação"));
        // $("#entrada1").text("Primeira entrada: " + (item.entrada1 || "Sem informação"));
        // $("#saida1").text("Primeira Saída: " + (item.saida1 || "Sem informação"));
        // $("#entrada2").text("Segunda entrada: " + (item.entrada2 || "Sem informação"));
        // $("#saida2").text("Segunda saída: " + (item.saida2 || "Sem informação"));
        $("#total").text("Carga horária diária: " + (item.total || "Sem informação"));
        $("#carga_horaria_mensal").text("Carga horária mensal: " + (item.carga_horaria || "Sem informação"));

        if (item.escala){
          $("#escala_input").val(item.escala);
        }
        if (item.tipo){
          $("#tipoCargaHoraria_input").val(item.tipo);
        }
        if (item.entrada1){
          $("#entrada1_input").val(item.entrada1);
        }
        if (item.saida1){
          $("#saida1_input").val(item.saida1);
        }
        if (item.entrada2){
          $("#entrada2_input").val(item.entrada2);
        }
        if (item.saida2){
          $("#saida2_input").val(item.saida2);
        }

        var dia_trabalhado = (item.dias_trabalhados ? item.dias_trabalhados.split(",") : []);
        var dia_folga = (item.folga ? item.folga.split(",") : []);
        for (var i = 0; i < dia_trabalhado.length; i++) {
          $("#diaTrabalhado_" + dia_trabalhado[i]).prop("checked", true);
        }
        for (var j = 0; j < dia_folga.length; j++) {
          $("#diaFolga_" + dia_folga[j]).prop("checked", true);
        }
      })
    });
    /*if (item.usa_vtp== "Possui") {
           
                  $("#radioTransportePossui").prop('checked',true).prop('disabled', true);
                  $("#radioTransporteNaoPossui").prop('checked',false).prop('disabled', true);
                  $("#esconder_exibir").show();
                  $("#num_transporte").val(item.vale_transporte).prop('disabled', true);
                  
                }else {
                  
                  $("#radioTransportePossui").prop('checked',false).prop('disabled', true);
                  $("#radioTransporteNaoPossui").prop('checked',true).prop('disabled', true);

                }

                if (item.cesta_basica=="Possui") {
                  $("#cesta_basicaPossui").prop('checked',true).prop('disabled', true);
                  $("#cesta_basicaNaoPossui").prop('checked',false).prop('disabled', true);
                }else{
                  $("#cesta_basicaPossui").prop('checked',false).prop('disabled', true);
                  $("#cesta_basicaNaoPossui").prop('checked',true).prop('disabled', true);
                }*/

    //Beneficios
    $(function() {

      var beneficio = <?= $bene ?>;
      $.each(beneficio, function(i, item) {
        $("#tabela")
          .append($("<tr>")
            .attr("class", "teste")
            .append($("<td>")
              .text(item.descricao_beneficios))
            .append($("<td>")
              .text(item.beneficios_status))
            .append($("<td >")
              .text(item.data_inicio))
            .append($("<td >")
              .text(item.data_fim))
            .append($("<td >")
              .text(item.valor))
            .append($('<td />')
              //.attr("onclick", "clicar_beneficio('" + item.id_funcionario+"')")
              .html('<button style="background-color: rgb(0,160,0); border-color: rgb(0,170,0); border-radius: 10%; color: white; " onclick="clicar_beneficio(' + item.id_funcionario + ')" class="glyphicon glyphicon-pencil"></button>' + ' ' +
                '<button style="background-color: rgb(190,0,0); border-color: rgb(165,0,0); border-radius: 10%; color: white; " onclick="excluir_beneficio(' + item.id_beneficiados + ')" onclick="" class="glyphicon glyphicon-trash"></button>'))

          );
      })
    });
    //});
    /*
    $("#beneficios").val(item.id_beneficios).prop('disabled', true);
    $("#beneficios_status").val(item.beneficios_status).prop('disabled', true);
    $("#inicio").val(item.data_inicio).prop('disabled', true);
    $("#data_fim").val(item.data_fim).prop('disabled', true);
    */
    //EPI
    $(function() {

      var epi = <?= $epi ?>;
      $.each(epi, function(i, item) {
        $("#tabela_epi")
          .append($("<tr>")
            .attr("class", "teste")
            .append($("<td>")
              .text(item.descricao_epi))
            .append($("<td>")
              .text(item.epi_status))
            .append($("<td >")
              .text(item.data))
            .append($('<td />')
              //.attr("onclick", "clicar_epi('" + item.id_funcionario+"')")
              .html('<button style="background-color: rgb(0,160,0); border-color: rgb(0,170,0); border-radius: 10%; color: white; " onclick="clicar_epi(' + item.id_funcionario + ')" class="glyphicon glyphicon-pencil"></button>' + ' ' +
                '<button style="background-color: rgb(190,0,0); border-color: rgb(165,0,0); border-radius: 10%; color: white; " onclick="excluir_epi(' + item.id_pessoa_epi + ')" class="glyphicon glyphicon-trash"></button>'))
          );

        //});
        /*
        $("#descricao_epi").val(item.id_epi).prop('disabled', true);
        $("#epi_status").val(item.epi_status).prop('disabled', true);
        $("#data").val(item.data).prop('disabled', true);
        */
      })
    });

    $(function(){
      var docfuncional = <?= $docfuncional?>;

      $.each(docfuncional,function(i, item) {
        $("#doc-tab")
          .append($("<tr>")
            .append($("<td>").text(item.nome_docfuncional))
            .append($("<td>").text(item.data))
            .append($("<td style='display: flex; justify-content: space-evenly;'>")
              .append($("<a href='./funcionario/documento_download.php?id_doc="+item.id_fundocs+"' title='Visualizar ou Baixar'><button class='btn btn-primary'><i class='fas fa-download'></i></button></a>"))
              .append($("<a href='./funcionario/documento_excluir.php?id_doc="+item.id_fundocs+"&id_funcionario=<?= $_GET["id_funcionario"]?>' title='Excluir'><button class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></a>"))
            )
          )
      });
    });

    $(function () {
			$('#datatable-docfuncional').DataTable( {
				"order": [[ 0, "asc" ]]
			} );
    });
    
    function listarDependentes(dependente){
      console.log(dependente);
      $("#dep-tab").empty();
      $.each(dependente,function(i, dependente) {
        dependente.cpf = [dependente.cpf.slice(0, 3), ".", dependente.cpf.slice(3, 6), ".", dependente.cpf.slice(6, 9), "-", dependente.cpf.slice(9, 11)].join("")
        $("#dep-tab")
          .append($("<tr>")
            .append($("<td>").text(dependente.nome))
            .append($("<td>").text(dependente.cpf))
            .append($("<td>").text(dependente.parentesco))
            .append($("<td style='display: flex; justify-content: space-evenly;'>")
              .append($("<a href='#' title='Editar'><button class='btn btn-primary'><i class='fas fa-user-edit'></i></button></a>"))
              .append($("<button class='btn btn-danger' onclick='removerDependente("+dependente.id_dependente+")'><i class='fas fa-trash-alt'></i></button>"))
            )
          )
      });
    }

    $(function(){
      listarDependentes(<?= $dependente?>);
    });

    $(function () {
			$('#datatable-dependente').DataTable( {
				"order": [[ 0, "asc" ]]
			} );
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


    /*function exibir_vale_transporte() {
    
       $("#esconder_exibir").show();
    
    }
    
    function esconder_vale_transporte() {
       
       document.getElementById('num_transporte').value=("");
       $("#esconder_exibir").hide();
    
    }*/

    function exibir_reservista() {

      $("#reservista1").show();
      $("#reservista2").show();
    }

    function esconder_reservista() {

      $("#reservista1").hide();
      $("#reservista2").hide();
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

    function testaCPF(strCPF) { //strCPF é o cpf que será validado. Ele deve vir em formato string e sem nenhum tipo de pontuação.
      var strCPF = strCPF.replace(/[^\d]+/g, ''); // Limpa a string do CPF removendo espaços em branco e caracteres especiais. 
      // PODE SER QUE NÃO ESTEJA LIMPANDO COMPLETAMENTE. FAVOR FAZER O TESTE!!!!
      var Soma;
      var Resto;
      Soma = 0;
      if (strCPF == "00000000000") return false;

      for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
      Resto = (Soma * 10) % 11;

      if ((Resto == 10) || (Resto == 11)) Resto = 0;
      if (Resto != parseInt(strCPF.substring(9, 10))) return false;

      Soma = 0;
      for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
      Resto = (Soma * 10) % 11;

      if ((Resto == 10) || (Resto == 11)) Resto = 0;
      if (Resto != parseInt(strCPF.substring(10, 11))) return false;
      return true;
    }

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
      $("#header").load("header.php");
      $(".menuu").load("menu.php");
    });

    function gerarSituacao() {
      url = '../dao/exibir_situacao.php';
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
      url = '../dao/adicionar_situacao.php';
      var situacao = window.prompt("Cadastre uma Nova Situação:");
      if (!situacao) {
        return
      }
      situacao = situacao.trim();
      if (situacao == '') {
        return
      }

      data = 'situacao=' + situacao;

      // console.log(data);
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
      url = '../dao/exibir_cargo.php';
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
      url = '../dao/adicionar_cargo.php';
      var cargo = window.prompt("Cadastre um Novo Cargo:");
      if (!cargo) {
        return
      }
      situacao = cargo.trim();
      if (cargo == '') {
        return
      }

      data = 'cargo=' + cargo;
      // console.log(data);
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response) {
          gerarCargo();
        },
        dataType: 'text'
      })
    }

    function gerarBeneficios() {
      url = '../dao/exibir_beneficios.php';
      $.ajax({
        data: '',
        type: "POST",
        url: url,
        async: true,
        success: function(response) {

          var beneficios = response;
          $('#ibeneficios').empty();
          $('#ibeneficios').append('<option selected disabled>Selecionar</option>');
          $.each(beneficios, function(i, item) {
            $('#ibeneficios').append('<option value="' + item.id_beneficios + '">' + item.descricao_beneficios + '</option>');
          });
        },
        dataType: 'json'
      });
    }

    function adicionar_beneficios() {
      url = '../dao/adicionar_beneficios.php';
      var beneficios = window.prompt("Cadastre um Novo Benefício:");
      if (!beneficios) {
        return
      }
      situacao = beneficios.trim();
      if (beneficios == '') {
        return
      }
      data = 'beneficios=' + beneficios;
      // console.log(data);
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response) {
          gerarBeneficios();
        },
        dataType: 'text'
      })
    }

    function gerarEpi() {
      url = '../dao/exibir_epi.php';
      $.ajax({
        data: '',
        type: "POST",
        url: url,
        async: true,
        success: function(response) {
          var epi = response;
          $('#descricao_epi').empty();
          $('#descricao_epi').append('<option selected disabled>Selecionar</option>');
          $.each(epi, function(i, item) {
            $('#descricao_epi').append('<option value="' + item.id_epi + '">' + item.descricao_epi + '</option>');
          });
        },
        dataType: 'json'
      });
    }

    function adicionar_epi() {
      url = '../dao/adicionar_epi.php';
      var descricao_epi = window.prompt("Cadastre uma Nova Epi:");
      if (!descricao_epi) {
        return
      }
      situacao = descricao_epi.trim();
      if (descricao_epi == '') {
        return
      }
      data = 'descricao_epi=' + descricao_epi;
      // console.log(data);
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response) {
          gerarEpi();
        },
        dataType: 'text'
      })
    }

    function funcao1() {
      alert("Cadastrado com sucesso o Benefício!");
    }

    function funcao2() {
      alert("Cadastrado com sucesso o EPI!");
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
        <?php getMsgSession("msg","tipo");?>


        <div class="row">
          <div class="col-md-4 col-lg-3">
            <section class="panel">
              <div class="panel-body">
                <div class="thumb-info mb-md">
                  <?php
                  /*
                                 if($_SERVER['REQUEST_METHOD'] == 'POST')
                                 {
                                   if(isset($_FILES['imgperfil']))
                                   {
                                    $image = file_get_contents ($_FILES['imgperfil']['tmp_name']);
                                    //session_start();
                                    if ($image){
                                      $_SESSION['imagem']=$image;
                                      echo '<img src="data:image/gif;base64,'.base64_encode($image).'" class="rounded img-responsive" alt="John Doe">';
                                    }else{
                                      echo '<img src="../img/semfoto.png" class="rounded img-responsive" alt="John Doe">';
                                    }
                                   } 
                                 }
                                 else
                                 {
                                  echo '<img src="../img/semfoto.png" class="rounded img-responsive" alt="John Doe">';
                                 }
                                 */


                  $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                  $id_pessoa = $_SESSION['id_pessoa'];
                  $donoimagem = $_GET['id_funcionario'];
                  //$resultado = mysqli_query($conexao, "SELECT `imagem`, `nome` FROM `pessoa` WHERE id_pessoa=$id_pessoa");
                  $resultado = mysqli_query($conexao, "SELECT pessoa.imagem, pessoa.nome FROM pessoa, funcionario  WHERE pessoa.id_pessoa=funcionario.id_pessoa and funcionario.id_funcionario=$donoimagem");
                  $pessoa = mysqli_fetch_array($resultado);
                  if (isset($_SESSION['id_pessoa']) and !empty($_SESSION['id_pessoa'])) {
                    $foto = $pessoa['imagem'];
                    if ($foto != null and $foto != "")
                      $foto = 'data:image;base64,' . $foto;
                    else $foto = WWW . "img/semfoto.png";
                  }
                  echo "<img src='$foto' id='imagem' class='rounded img-responsive' alt='John Doe'>";

                  ?>
                  <i class="fas fa-camera-retro btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></i>
                  <div class="container">
                    <div class="modal fade" id="myModal" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Adicionar uma Foto</h4>
                          </div>
                          <div class="modal-body">
                            <form class="form-horizontal" method="POST" action="../controle/control.php" enctype="multipart/form-data">
                              <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                              <input type="hidden" name="metodo" value="alterarImagem">
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="imgperfil">Carregue nova imagem de perfil:</label>
                                <div class="col-md-8">
                                  <input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
                                </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?>>
                            <input type="submit" id="formsubmit" value="Alterar imagem">
                          </div>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="widget-toggle-expand mb-md">
                  <div class="widget-header">
                    <div class="widget-content-expanded">
                      <ul class="simple-todo-list">
                      </ul>
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
                  <a href="#overview" data-toggle="tab">Visão Geral</a>
                </li>
                <li>
                  <a href="#beneficio" data-toggle="tab">Benefício</a>
                </li>
                <li>
                  <a href="#epi" data-toggle="tab">Epi</a>
                </li>
                <li>
                  <a href="#editar_cargaHoraria" data-toggle="tab">Carga Horária</a>
                </li>
                <li>
                  <a href="#documentos" data-toggle="tab">Documentação</a>
                </li>
                <li>
                  <a href="#dependentes" data-toggle="tab">Dependentes</a>
                </li>
              </ul>
              <div class="tab-content">
                <div id="overview" class="tab-pane active">
                  <form class="form-horizontal" method="post" action="../controle/control.php">
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
                        <label class="col-md-3 control-label" for="profileFirstName">Sobreome</label>
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
                        <label class="col-md-3 control-label" for="profileFirstName">Nome do pai</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="nome_pai" id="pai" onkeypress="return Onlychars(event)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">Nome da mãe</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="nome_mae" id="mae" onkeypress="return Onlychars(event)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">Tipo sanguíneo</label>
                        <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="sangue" id="sangue">
                            <option selected disabled>Selecionar</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                          </select>
                        </div>
                      </div>
                      <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?>>
                      <button type="button" class="btn btn-primary" id="botaoEditarIP" onclick="return editar_informacoes_pessoais()">Editar</button>
                      <input type="submit" class="btn btn-primary" disabled="true" value="Salvar" id="botaoSalvarIP">
                  </form>

                  <br />
                  <hr class="dotted short">
                  <h4 class="mb-xlg">Endereço</h4>
                  <form class="form-horizontal" method="post" action="../controle/control.php">
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
                    <br />
                    <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?>>
                    <button type="button" class="btn btn-primary" id="botaoEditarEndereco" onclick="return editar_endereco()">Editar</button>
                    <input type="submit" class="btn btn-primary" disabled="true" value="Salvar" id="botaoSalvarEndereco" disabled="true">
                  </form>

                  <!--Documentação-->
                  <hr class="dotted short">
                  <form class="form-horizontal" method="post" action="../controle/control.php">
                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                    <input type="hidden" name="metodo" value="alterarDocumentacao">
                    <h4 class="mb-xlg doch4">Documentação</h4>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Número do RG</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="rg" id="rg" onkeypress="return Onlynumbers(event)" placeholder="Ex: 22.222.222-2" onkeyup="mascara('##.###.###-#',this,event)">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Órgão Emissor</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="orgao_emissor" id="orgao_emissor" onkeypress="return Onlychars(event)">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Data de expedição</label>
                      <div class="col-md-6">
                        <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" name="data_expedicao" id="data_expedicao" max=<?php echo date('Y-m-d'); ?>>
                      </div>
                    </div>
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
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Data de Admissão</label>
                      <div class="col-md-8">
                        <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data_admissao" id="data_admissao" max=<?php echo date('Y-m-d'); ?>>
                      </div>
                    </div>
                    <br />
                    <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?>>
                    <button type="button" class="btn btn-primary" id="botaoEditarDocumentacao" onclick="return editar_documentacao()">Editar</button>
                    <input id="botaoSalvarDocumentacao" type="submit" class="btn btn-primary" disabled="true" value="Salvar" onclick="funcao3()">
                  </form>
                  <!--Outros-->
                  <hr class="dotted short">
                  <form class="form-horizontal" method="POST" action="../controle/control.php">
                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                    <input type="hidden" name="metodo" value="alterarOutros">
                    <h4 class="mb-xlg doch4">Outros</h4>
                    <div class="form-group">
                      <label class="col-md-3 control-label">PIS</label>
                      <div class="col-md-6">
                        <input type="text" id="pis" name="pis" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label">CTPS</label>
                      <div class="col-md-6">
                        <input type="text" id="ctps" name="ctps" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="uf">Estado CTPS</label>
                      <div class="col-md-6">
                        <input type="text" name="uf_ctps" size="60" class="form-control" id="uf_ctps">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label">Título de eleitor</label>
                      <div class="col-md-6">
                        <input type="text" name="titulo_eleitor" id="titulo_eleitor" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label">Zona eleitoral</label>
                      <div class="col-md-6">
                        <input type="text" name="zona_eleitoral" id="zona_eleitoral" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label">Seção do título de eleitor</label>
                      <div class="col-md-6">
                        <input type="text" name="secao_titulo_eleitor" id="secao_titulo_eleitor" class="form-control">
                      </div>
                    </div>
                    <div class="form-group" id="reservista1" style="display: none">
                      <label class="col-md-3 control-label">Número do certificado reservista</label>
                      <div class="col-md-6">
                        <input type="text" id="certificado_reservista_numero" name="certificado_reservista_numero" class="form-control num_reservista">
                      </div>
                    </div>
                    <div class="form-group" id="reservista2" style="display: none">
                      <label class="col-md-3 control-label">Série do certificado reservista</label>
                      <div class="col-md-6">
                        <input type="text" id="certificado_reservista_serie" name="certificado_reservista_serie" class="form-control serie_reservista">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-3 control-label" for="inputSuccess">Situação</label>
                      <a onclick="adicionar_situacao()"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                      <div class="col-md-6">
                        <select class="form-control input-lg mb-md" name="situacao" id="situacao">
                          <option selected disabled>Selecionar</option>
                          <?php
                          while ($row = $situacao->fetch_array(MYSQLI_NUM)) {
                            echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                          }                            ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-3 control-label" for="inputSuccess">Cargo</label>
                      <a onclick="adicionar_cargo()"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                      <div class="col-md-6">
                        <select class="form-control input-lg mb-md" name="cargo" id="cargo">
                          <option selected disabled>Selecionar</option>
                          <?php
                          while ($row = $cargo->fetch_array(MYSQLI_NUM)) {
                            echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                          }                            ?>
                        </select>
                      </div>
                    </div>

                    <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?>>
                    <button type="button" class="btn btn-primary" id="botaoEditarOutros" onclick="return editar_outros()">Editar</button>
                    <input type="submit" class="btn btn-primary" disabled="true" value="Salvar" id="botaoSalvarOutros" disabled="true">
                  </form>
                  <div class="panel-footer">
                    <div class="row">
                      <div class="col-md-9 col-md-offset-3">
                        <button id="excluir" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exclusao">Excluir</button>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="exclusao" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">×</button>
                          <h3>Excluir um Funcionário</h3>
                        </div>
                        <div class="modal-body">
                          <p> Tem certeza que deseja excluir esse funcionário? Essa ação não poderá ser desfeita e todas as informações referentes a esse funcionário serão perdidas!</p>
                          <a href="../controle/control.php?metodo=excluir&nomeClasse=FuncionarioControle&id_funcionario=<?php echo $_GET['id_funcionario']; ?>"><button button type="button" class="btn btn-success">Confirmar</button></a>
                          <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 
                  Aba de benefícios do funcionário

                -->

                <div id="beneficio" class="tab-pane">
                  <section class="panel">
                    <header class="panel-heading">
                      <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                      </div>

                      <h2 class="panel-title">Benefícios</h2>
                    </header>
                    <div class="panel-body">
                      <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                          <tr>
                            <th>Benefício</th>
                            <th>Benefício Status</th>
                            <th>Data Início</th>
                            <th>Data Fim</th>
                            <th>Valor</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="tabela">

                        </tbody>

                      </table>
                    </div><br>
                    <div class="panel-footer">
                      <div class="row">
                        <div class="col-md-9 col-md-offset-3">
                          <button id="excluir" type="button" class="btn btn-success" data-toggle="modal" data-target="#adicionar">Adicionar</button>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="adicionar" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Adicionar Benefício</h3>
                          </div>
                          <div class="modal-body">
                            <form class="form-horizontal" method="POST" action="../controle/control.php">
                              <h4 class="mb-xlg">Benefícios</h4>
                              <div id="beneficio" class="tab-pane">
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="inputSuccess">Benefícios</label>
                                  <a onclick="adicionar_beneficios()"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                  <div class="col-md-6">
                                    <select class="form-control input-lg mb-md" name="ibeneficios" id="ibeneficios">
                                      <option selected disabled>Selecionar</option>
                                      <?php
                                      while ($row = $beneficios->fetch_array(MYSQLI_NUM)) {
                                        echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                                      } ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="inputSuccess">Benefícios Status</label>
                                  <div class="col-md-6">
                                    <select class="form-control input-lg mb-md" name="beneficios_status" id="beneficios_status">
                                      <option selected disabled>Selecionar</option>
                                      <option value="Ativo">Ativo</option>
                                      <option value="Inativo">Inativo</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Data Início</label>
                                  <div class="col-md-8">
                                    <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data_inicio" id="inicio" max=<?php echo date('Y-m-d'); ?>>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Data Fim</label>
                                  <div class="col-md-8">
                                    <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data_fim" id="data_fim">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Valor</label>
                                  <div class="col-md-8">
                                    <input type="text" name="valor" class="dinheiro form-control" id="profileCompany" id="valor" maxlength="13" placeholder="Ex: 22.00" onkeypress="return Onlynumbers(event)">
                                  </div>
                                </div>
                              </div>
                              <br>
                              <div class="panel-footer">
                                <div class="row">
                                  <div class="col-md-9 col-md-offset-3">
                                    <input type="hidden" name="person" value=<?php echo $_GET['id_funcionario']; ?>>
                                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                    <input type="hidden" name="metodo" value="incluirBeneficio">
                                    <input id="enviar" type="submit" class="btn btn-primary" value="Salvar" onclick="funcao1()">
                                    <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <!-- 
                  Aba epi do funcionario

                -->

                <div id="epi" class="tab-pane">
                  <section class="panel">
                    <header class="panel-heading">
                      <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                      </div>

                      <h2 class="panel-title">Epi</h2>
                    </header>
                    <div class="panel-body">
                      <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                          <tr>
                            <th>Epi</th>
                            <th>Epi Status</th>
                            <th>Data</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="tabela_epi">

                        </tbody>
                      </table>
                    </div><br>
                    <div class="panel-footer">
                      <div class="row">
                        <div class="col-md-9 col-md-offset-3">
                          <button id="excluir" type="button" class="btn btn-success" data-toggle="modal" data-target="#adicionar_epi">Adicionar</button>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="adicionar_epi" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Adicionar EPI</h3>
                          </div>
                          <div class="modal-body">
                            <form class="form-horizontal" method="POST" action="../controle/control.php">
                              <h4 class="mb-xlg">EPI</h4>
                              <div id="epi" class="tab-pane">
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="inputSuccess">EPI</label>
                                  <a onclick="adicionar_epi()"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                  <div class="col-md-6">
                                    <select class="form-control input-lg mb-md" name="descricao_epi" id="descricao_epi">
                                      <option selected disabled>Selecionar</option>
                                      <?php
                                      while ($row = $descricao_epi->fetch_array(MYSQLI_NUM)) {
                                        echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                                      } ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="inputSuccess">EPI Status</label>
                                  <div class="col-md-6">
                                    <select class="form-control input-lg mb-md" name="epi_status" id="epi_status">
                                      <option selected disabled>Selecionar</option>
                                      <option value="Ativo">Ativo</option>
                                      <option value="Inativo">Inativo</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Data</label>
                                  <div class="col-md-8">
                                    <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data" id="data" max=<?php echo date('Y-m-d'); ?>>
                                  </div>
                                </div>
                              </div><br>
                              <div class="panel-footer">
                                <div class="row">
                                  <div class="col-md-9 col-md-offset-3">
                                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                    <input type="hidden" name="person2" value=<?php echo $_GET['id_funcionario']; ?>>
                                    <input type="hidden" name="metodo" value="incluirEpi">
                                    <input id="enviar" type="submit" class="btn btn-primary" value="Salvar" onclick="funcao2()">
                                    <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>

                <!-- 
                  Aba de carga horária do funcionário

                -->

                <div id="editar_cargaHoraria" class="tab-pane">
                  <section class="panel">
                    <header class="panel-heading">
                      <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                      </div>

                      <h2 class="panel-title">Carga Horária</h2>
                    </header>
                    <div class="panel-body">
                      <form class="form-horizontal" method="post" action="../controle/control.php">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Escala</label>
                          <div class="col-md-6">
                            <select class="form-control input-lg mb-md" name="escala" id="escala_input">
                              <option id="escala_default" selected disabled value="">Selecionar</option>
                              <?php
                              $pdo = Conexao::connect();
                              $escala = $pdo->query("SELECT * FROM escala_quadro_horario;")->fetchAll(PDO::FETCH_ASSOC);
                              foreach ($escala as $key => $value) {
                                echo ("<option id='escala_".$value["id_escala"]."' value=" . $value["id_escala"] . ">" . $value["descricao"] . "</option>");
                              }
                              ?>
                            </select>
                          </div>
                          <a href="./quadro_horario/adicionar_escala.php"><i class="fas fa-plus w3-xlarge"></i></a>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Tipo</label>
                          <div class="col-md-6">
                            <select class="form-control input-lg mb-md" name="tipoCargaHoraria" id="tipoCargaHoraria_input">
                              <option selected disabled value="">Selecionar</option>
                              <?php
                              $pdo = Conexao::connect();
                              $tipo = $pdo->query("SELECT * FROM tipo_quadro_horario;")->fetchAll(PDO::FETCH_ASSOC);
                              foreach ($tipo as $key => $value) {
                                echo ("<option value=" . $value["id_tipo"] . ">" . $value["descricao"] . "</option>");
                              }
                              ?>
                            </select>
                          </div>
                          <a href="./quadro_horario/adicionar_tipo_quadro_horario.php"><i class="fas fa-plus w3-xlarge"></i></a>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Primeira entrada</label>
                          <div class="col-md-3">
                            <input type="time" placeholder="07:25" class="form-control" name="entrada1" id="entrada1_input">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Primeira saída</label>
                          <div class="col-md-3">
                            <input type="time" placeholder="07:25" class="form-control" name="saida1" id="saida1_input">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Segunda entrada</label>
                          <div class="col-md-3">
                            <input type="time" placeholder="07:25" class="form-control" name="entrada2" id="entrada2_input">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Segunda saída</label>
                          <div class="col-md-3">
                            <input type="time" placeholder="07:25" class="form-control" name="saida2" id="saida2_input">
                          </div>
                        </div>
                        <div class="text-center">
                          <h3 class="col-md-12">Dias Trabalhados</h3>
                          <div class="btn-group ">
                            <label class="btn btn-primary ">
                              <input type="checkbox" id="diaTrabalhado_Seg" name="trabSeg" value="Seg">Seg
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado_Ter" name="trabTer" value="Ter"> Ter
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado_Qua" name="trabQua" value="Qua"> Qua
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado_Qui" name="trabQui" value="Qui"> Qui
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado_Sex" name="trabSex" value="Sex"> Sex
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado_Sab" name="trabSab" value="Sab"> Sab
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado_Dom" name="trabDom" value="Dom"> Dom
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado_Plantão" name="plantao" value="Plantão"> Plantão 12/36
                              <span class="fa fa-check"></span>
                            </label>
                          </div>
                        </div>

                        <div class="text-center">
                          <h3 class="col-md-12">Dias de Folga</h3>
                          <div class="btn-group ">
                            <label class="btn btn-primary ">
                              <input type="checkbox" id="diaFolga_Seg" name="folgaSeg" value="Seg">Seg
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaFolga_Ter" name="folgaTer" value="Ter"> Ter
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaFolga_Qua" name="folgaQua" value="Qua"> Qua
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaFolga_Qui" name="folgaQui" value="Qui"> Qui
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaFolga_Sex" name="folgaSex" value="Sex"> Sex
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaFolga_Sab" name="folgaSab" value="Sab"> Sab
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaFolga_Dom" name="folgaDom" value="Dom"> Dom
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="folgaAlternado" value="Alternado"> Alternado
                              <span class="fa fa-check"></span>
                            </label>
                          </div>
                        </div>
                        <div class="">
                          <h3 class="text-center col-md-12">Carga Horária</h3>
                          <ul class="nav nav-children" id="info">
                            <li id="total">Carga horária diária:</li></br>
                            <li id="carga_horaria_mensal">Carga horária mensal:</li>
                          </ul>
                        </div>
                        <hr class="dotted short">
                        <div class="panel-footer">
                          <div class="row">
                            <div class="col-md-9 col-md-offset-3">

                              <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                              <input type="hidden" name="metodo" value="alterarCargaHoraria">
                              <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?>>
                              <input id="enviarCarga" type="submit" class="btn btn-primary" value="Alterar carga">

                              <input type="reset" class="btn btn-default">
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </section>
                </div>

                <!-- 
                  Aba de documentos do funcionário 

                -->

                <div id="documentos" class="tab-pane">
                  <section class="panel">
                    <header class="panel-heading">
                      <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                      </div>

                      <h2 class="panel-title">Documentos</h2>
                    </header>
                    <div class="panel-body">
                      <table class="table table-bordered table-striped mb-none" id="datatable-docfuncional">
                        <thead>
                          <tr>
                            <th>Documento</th>
                            <th>Data</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="doc-tab">

                        </tbody>
                      </table>
                      <br>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docFormModal">
                        Adicionar Documento
                      </button>

                      <!-- Modal Form Documentos -->
                      <div class="modal fade" id="docFormModal" tabindex="-1" role="dialog" aria-labelledby="docFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header" style="display: flex;justify-content: space-between;">
                              <h5 class="modal-title" id="exampleModalLabel">Adicionar Documento</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action='./funcionario/documento_upload.php' method='post' enctype='multipart/form-data' id='funcionarioDocForm'> 
                              <div class="modal-body" style="padding: 15px 40px">
                                <div class="form-group" style="display: grid;">
                                  <label class="my-1 mr-2" for="tipoDocumento">Tipo de Documento</label><br>
                                  <div style="display: flex;">
                                    <select name="id_docfuncional" class="custom-select my-1 mr-sm-2" id="tipoDocumento" required>
                                      <option selected disabled>Selecionar...</option>
                                      <?php
                                        foreach ($pdo->query("SELECT * FROM funcionario_docfuncional ORDER BY nome_docfuncional ASC;")->fetchAll(PDO::FETCH_ASSOC) as $item){
                                          echo("
                                          <option value='".$item["id_docfuncional"]."' >".$item["nome_docfuncional"]."</option>
                                          ");
                                        }
                                      ?>
                                    </select>
                                    <a onclick="adicionarDocFuncional()" style="margin: 0 20px;"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="arquivoDocumento">Arquivo do Documento</label>
                                  <input name="arquivo" type="file" class="form-control-file" id="arquivoDocumento" accept="png;jpeg;jpg;pdf;docx;doc;odp" required>
                                </div>

                                <input type="number" name="id_funcionario" value="<?= $_GET['id_funcionario'];?>" style='display: none;'>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input type="submit" value="Enviar" class="btn btn-primary">
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>


                    </div>
                </div>

                <div id="dependentes" class="tab-pane">
                  <section class="panel">
                    <header class="panel-heading">
                      <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                      </div>
                      <h2 class="panel-title">Dependentes</h2>
                    </header>
                    <div class="panel-body">
                      <table class="table table-bordered table-striped mb-none" id="datatable-dependente">
                        <thead>
                          <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Parentesco</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="dep-tab">

                        </tbody>
                      </table>
                      <br>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#depFormModal">
                        Adicionar Dependente
                      </button>

                      <!-- Modal Form Dependentes -->
                      <div class="modal fade" id="depFormModal" tabindex="-1" role="dialog" aria-labelledby="depFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header" style="display: flex;justify-content: space-between;">
                              <h5 class="modal-title" id="exampleModalLabel">Adicionar Documento</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action='./funcionario/dependente_cadastrar.php' method='post' id='funcionarioDepForm'> 
                              <div class="modal-body" style="padding: 15px 40px">
                                <div class="form-group" style="display: grid;">
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
                                      <label><input type="radio" name="sexo" id="radio" id="M" value="m" style="margin-top: 10px; margin-left: 15px;" onclick="return exibir_reservista()" required><i class="fa fa-male" style="font-size: 20px;"></i></label>
                                      <label><input type="radio" name="sexo" id="radio" id="F" value="f" style="margin-top: 10px; margin-left: 15px;" onclick="return esconder_reservista()"><i class="fa fa-female" style="font-size: 20px;"></i> </label>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="telefone">Telefone</label>
                                    <div class="col-md-8">
                                      <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone" id="telefone" id="telefone" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="profileCompany">Nascimento<sup class="obrig">*</sup></label>
                                    <div class="col-md-8">
                                      <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" id="nascimento" max=<?php echo date('Y-m-d'); ?> required>
                                    </div>
                                  </div>
                                  <hr class="dotted short">
                                  <h4 class="mb-xlg doch4">Documentação</h4>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="cpf">Número do CPF<sup class="obrig">*</sup></label>
                                    <div class="col-md-6">
                                      <input type="text" class="form-control" id="cpf" id="cpf" name="cpf" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" required>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="profileCompany"></label>
                                    <div class="col-md-6">
                                      <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                  <label class="col-md-3 control-label" for="parentesco">Parentesco<sup class="obrig">*</sup></label>
                                    <div class="col-md-6" style="display: flex;">
                                        <select name="id_parentesco" id="parentesco">
                                          <option selected disabled>Selecionar...</option>
                                          <?php
                                            foreach ($pdo->query("SELECT * FROM funcionario_dependente_parentesco ORDER BY descricao ASC;")->fetchAll(PDO::FETCH_ASSOC) as $item){
                                              echo("
                                              <option value='".$item["id_parentesco"]."' >".$item["descricao"]."</option>
                                              ");
                                            }
                                          ?>
                                        </select>
                                        <a onclick="adicionarParentesco()" style="margin: 0 20px;"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="profileCompany">Número do RG</label>
                                    <div class="col-md-6">
                                      <input type="text" class="form-control" name="rg" id="rg" onkeypress="return Onlynumbers(event)" placeholder="Ex: 22.222.222-2" onkeyup="mascara('##.###.###-#',this,event)">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="profileCompany">Órgão Emissor</label>
                                    <div class="col-md-6">
                                      <input type="text" class="form-control" name="orgao_emissor" id="profileCompany" id="orgao_emissor" onkeypress="return Onlychars(event)">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="profileCompany">Data de expedição</label>
                                    <div class="col-md-6">
                                      <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" id="profileCompany" name="data_expedicao" id="data_expedicao" max=<?php echo date('Y-m-d'); ?>>
                                    </div>
                                  </div>
                                  <input type="hidden" name="id_funcionario" value="<?= $_GET['id_funcionario'];?>" readonly>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" value="Enviar" class="btn btn-primary">
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
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

  <!-- Vendor -->
  <script src="../assets/vendor/select2/select2.js"></script>
  <script src="../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
  <script src="../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
  <script src="../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

  <!-- Theme Base, Components and Settings -->
  <script src="../assets/javascripts/theme.js"></script>

  <!-- Theme Custom -->
  <script src="../assets/javascripts/theme.custom.js"></script>

  <!-- Metodo Post -->
  <script src="./geral/post.js"></script>

  <!-- Theme Initialization Files -->
  <script src="../assets/javascripts/theme.init.js"></script>


  <!-- Examples -->
  <script src="../assets/javascripts/tables/examples.datatables.default.js"></script>
  <script src="../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
  <script src="../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
  <script>
    function funcao3() {
      var idfunc = <?php echo $_GET['id_funcionario']; ?>;
      var cpfs = <?php echo $_SESSION['cpf_funcionario']; ?>;
      var cpf_funcionario = $("#cpf").val();
      var cpf_funcionario_correto = cpf_funcionario.replace(".", "");
      var cpf_funcionario_correto1 = cpf_funcionario_correto.replace(".", "");
      var cpf_funcionario_correto2 = cpf_funcionario_correto1.replace(".", "");
      var cpf_funcionario_correto3 = cpf_funcionario_correto2.replace("-", "");
      var apoio = 0;
      var cpfs1 = <?php echo $_SESSION['cpf_interno']; ?>;
      $.each(cpfs, function(i, item) {
        if (item.cpf == cpf_funcionario_correto3 && item.id != idfunc) {
          alert("Alteração não realizada! O CPF informado já está cadastrado no sistema");
          apoio = 1;
        }
      });
      $.each(cpfs1, function(i, item) {
        if (item.cpf == cpf_funcionario_correto3) {
          alert("Cadastro não realizado! O CPF informado já está cadastrado no sistema");
          apoio = 1;
        }
      });
      if (apoio == 0) {
        alert("Editado com sucesso!");
      }
    }

    function gerarDocFuncional() {
      url = './funcionario/documento_listar.php';
      $.ajax({
        data: '',
        type: "POST",
        url: url,
        async: true,
        success: function(response) {
          var documento = response;
          $('#tipoDocumento').empty();
          $('#tipoDocumento').append('<option selected disabled>Selecionar...</option>');
          $.each(documento, function(i, item) {
            $('#tipoDocumento').append('<option value="' + item.id_docfuncional + '">' + item.nome_docfuncional + '</option>');
          });
        },
        dataType: 'json'
      });
    }

    function adicionarDocFuncional() {
      url = './funcionario/documento_adicionar.php';
      var nome_docfuncional = window.prompt("Cadastre um novo tipo de Documento:");
      console.log(nome_docfuncional);
      if (!nome_docfuncional) {
        return
      }
      nome_docfuncional = nome_docfuncional.trim();
      if (nome_docfuncional == '') {
        return
      }

      data = 'nome_docfuncional=' + nome_docfuncional;

      console.log(data);
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response) {
          gerarDocFuncional();
        },
        dataType: 'text'
      })
    }

    function gerarParentesco() {
      url = './funcionario/dependente_parentesco_listar.php';
      $.ajax({
        data: '',
        type: "POST",
        url: url,
        async: true,
        success: function(response) {
          var parentesco = response;
          console.log(parentesco);
          $('#parentesco').empty();
          $('#parentesco').append('<option selected disabled>Selecionar...</option>');
          $.each(parentesco, function(i, item) {
            $('#parentesco').append('<option value="' + item.id_parentesco + '">' + item.descricao + '</option>');
          });
        },
        dataType: 'json'
      });
    }

    function adicionarParentesco() {
      url = './funcionario/dependente_parentesco_adicionar.php';
      var descricao = window.prompt("Cadastre um novo tipo de Parentesco:");
      if (!descricao) {
        return
      }
      descricao = descricao.trim();
      if (descricao == '') {
        return
      }
      data = 'descricao=' + descricao;

      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response) {
          gerarParentesco();
        },
        dataType: 'text'
    })
    }

    function removerDependente(id_dep){
      let url = "./funcionario/dependente_remover.php";
      let data = "id_funcionario=<?= $_GET['id_funcionario'];?>&id_dependente="+id_dep;
      post(url, data, listarDependentes);
    }
  </script>
</body>

</html>