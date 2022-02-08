<?php 

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();

    // if(!isset($_SESSION['saude_id'])){
    //     header ("Location: profile_paciente.php?idsaude=$id");
    // }
   	if(!isset($_SESSION['usuario'])){
   		header ("Location: ../index.php");
   	}

     if(!isset($_SESSION['id_fichamedica']))	{
      header('Location: ../../controle/control.php?metodo=listarUm&nomeClasse=SaudeControle&nextPage=../html/saude/profile_paciente.php');
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

  
require_once "../../dao/Conexao.php";
$pdo = Conexao::connect();

$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$id_pessoa = $_SESSION['id_pessoa'];
$resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
if(!is_null($resultado)){
    $id_cargo = mysqli_fetch_array($resultado);
    if(!is_null($id_cargo)){
    $id_cargo = $id_cargo['id_cargo'];
    }
    $resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=5");
    if(!is_bool($resultado) and mysqli_num_rows($resultado)){
    $permissao = mysqli_fetch_array($resultado);
    if($permissao['id_acao'] < 7){
    $msg = "Você não tem as permissões necessárias para essa página.";
    header("Location: ../home.php?msg_c=$msg");
    }
    $permissao = $permissao['id_acao'];
    }else{
        $permissao = 1;
        $msg = "Você não tem as permissões necessárias para essa página.";
        header("Location: ../home.php?msg_c=$msg");
    }	
}else{
    $permissao = 1;
$msg = "Você não tem as permissões necessárias para essa página.";
header("Location: ../home.php?msg_c=$msg");
}	


  include_once '../../classes/Cache.php';    
  require_once "../personalizacao_display.php";

  require_once ROOT."/controle/SaudeControle.php";
   
  $id=$_GET['id_fichamedica']; 
  $cache = new Cache();
  $teste = $cache->read($id);

  require_once "../../dao/Conexao.php";
  $pdo = Conexao::connect();
   
  if (!isset($teste)) 
  {
   		header('Location: ../../controle/control.php?metodo=listarUm&nomeClasse=SaudeControle&nextPage=../html/saude/saude.php?id_fichamedica='.$id.'&id='.$id);
  }
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $intStatus = $mysqli->query("SELECT * FROM saude_enfermidades");


  $docfuncional = $pdo->query("SELECT * FROM saude_exames se JOIN saude_exame_tipos st ON se.id_exame_tipos  = st.id_exame_tipo WHERE id_fichamedica = " .$_GET['id_fichamedica']);
  $docfuncional = $docfuncional->fetchAll(PDO::FETCH_ASSOC);
  foreach ($docfuncional as $key => $value) {
    $docfuncional[$key]["arquivo"] = gzuncompress($value["arquivo"]);
  }
  $docfuncional = json_encode($docfuncional);

  $enfermidades = $pdo->query("SELECT sf.id_CID, sf.data_diagnostico, sf.status, stc.descricao FROM saude_enfermidades sf JOIN saude_tabelacid stc ON sf.id_CID = stc.id_CID WHERE sf.status = 1 AND id_fichamedica = " .$_GET['id_fichamedica']);
  $enfermidades = $enfermidades->fetchAll(PDO::FETCH_ASSOC);
  $enfermidades = json_encode($enfermidades);

  $descricao_medica = $pdo->query("SELECT descricao, data_atendimento FROM saude_atendimento WHERE id_fichamedica = " .$_GET['id_fichamedica']);
  $descricao_medica = $descricao_medica->fetchAll(PDO::FETCH_ASSOC);
  $descricao_medica = json_encode($descricao_medica);
  
  $exibimed = $pdo->query("SELECT data_atendimento, medicamento, dosagem, horario, duracao, st.descricao FROM saude_atendimento sa JOIN saude_medicacao sm ON (sa.id_atendimento=sm.id_atendimento) JOIN saude_medicacao_status st ON (sm.saude_medicacao_status_idsaude_medicacao_status = st.idsaude_medicacao_status)  WHERE id_fichamedica = " .$_GET['id_fichamedica']);
  $exibimed = $exibimed->fetchAll(PDO::FETCH_ASSOC);
  $exibimed = json_encode($exibimed);

  $exibimedparaenfermeiro = $pdo->query("SELECT * FROM saude_medicacao");
  $exibimedparaenfermeiro = $exibimedparaenfermeiro->fetchAll(PDO::FETCH_ASSOC);
  $exibimedparaenfermeiro = json_encode($exibimedparaenfermeiro);

  $medaplicadas = $pdo->query("SELECT medicamento, aplicação FROM saude_medicacao sm JOIN saude_medicamento_administracao sa ON (sm.id_medicacao = sa.saude_medicacao_id_medicacao)");
  $medaplicadas = $medaplicadas->fetchAll(PDO::FETCH_ASSOC);
  $medaplicadas = json_encode($medaplicadas);

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $tabelacid = $mysqli->query("SELECT * FROM saude_tabelacid");
  $cargoMedico = $mysqli->query("SELECT * FROM pessoa p JOIN funcionario f ON (p.id_pessoa=f.id_pessoa) WHERE f.id_cargo = 3");
  $cargoEnfermeiro = $mysqli->query("SELECT * FROM pessoa p JOIN funcionario f ON (p.id_pessoa=f.id_pessoa) WHERE f.id_cargo = 4");
  $tipoexame = $mysqli->query("SELECT * FROM saude_exame_tipos");
  $medicamentoenfermeiro = $mysqli->query("SELECT * FROM saude_medicacao"); 
  $descparaenfermeiro = $mysqli->query("SELECT descricao FROM saude_fichamedica");

  $teste = $pdo->query("SELECT nome FROM pessoa p JOIN funcionario f ON(p.id_pessoa = f.id_pessoa) WHERE f.id_pessoa = " .$_SESSION['id_pessoa'])->fetchAll(PDO::FETCH_ASSOC);
  $id_funcionario = $teste[0]['nome'];

  
?>
    <!-- Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        
    <!-- Specific Page Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        
    <!-- Theme Base, Components and Settings -->
    <!-- <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script> -->
        
    <!-- Theme Custom -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
    <!-- Theme Initialization Files -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>

    <!-- javascript functions -->
    <script src="<?php echo WWW;?>Functions/onlyNumbers.js"></script>
    <script src="<?php echo WWW;?>Functions/onlyChars.js"></script>
    <script src="<?php echo WWW;?>Functions/mascara.js"></script>

    <!-- jkeditor -->
    <script src="<?php echo WWW;?>assets/vendor/ckeditor/ckeditor.js"></script>
        
    <!-- Specific Page Vendor CSS -->
	  <link rel="stylesheet" href="../../assets/vendor/select2/select2.css" />
	  <link rel="stylesheet" href="../../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
    
	

    <!-- jquery functions -->

    <script>
        $(function(){
           
            $("#header").load("../header.php");
            $(".menuu").load("../menu.php");
            CKEDITOR.replace('despacho');
        });
    </script>
    

    <style type="text/css">
        .select{
            position: absolute;
            width: 235px;
        }
        .select-table-filter{
            width: 140px;
            float: left;
        }
        .panel-body{
            margin-bottom: 15px;
        }
        img{
        	margin-left:10px;
        }
        #div_texto
        {
            width: 100%;
        }
        #cke_despacho
        {
            height: 500px;
        }
        .cke_inner
        {
            height: 500px;
        }
        #cke_1_contents
        {
            height: 455px !important;
        }
        .col-md-3 {
            width: 10%;
        }
    </style>


<!doctype html>
<html class="fixed">
   <head>
      <!-- Basic -->
      <meta charset="UTF-8">
      <title>Informações paciente</title>
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <!-- Web Fonts  -->
      <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
      <!-- Vendor CSS -->
      <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.css" />
      <link rel="stylesheet" href="../../assets/vendor/font-awesome/css/font-awesome.css" />
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
      <link rel="stylesheet" href="../../assets/vendor/magnific-popup/magnific-popup.css" />
      <link rel="stylesheet" href="../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

      <link rel="stylesheet" type="text/css" href="../../css/profile-theme.css"> 
      </script> <script src="../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>  
      <script src="../../assets/vendor/nanoscroller/nanoscroller.js"></script>
      <script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
      <script src="../../assets/vendor/magnific-popup/magnific-popup.js"></script>
      <script src="../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
      <!-- Theme CSS -->
      <link rel="stylesheet" href="../../assets/stylesheets/theme.css" />
      <!-- Skin CSS -->
      <link rel="stylesheet" href="../../assets/stylesheets/skins/default.css" />
      <!-- Theme Custom CSS -->
      <link rel="stylesheet" href="../../assets/stylesheets/theme-custom.css">
      <!-- Head Libs -->
      <script src="../../assets/vendor/modernizr/modernizr.js"></script>
      <script src="../../Functions/lista.js"></script>
      <!-- JavaScript Functions -->
	    <script src="../../Functions/enviar_dados.js"></script>
      <script src="../../Functions/mascara.js"></script>
      
      <script>
        
        function excluirimg(id)
            {
               $("#excluirimg").modal('show');
               $('input[name="id_documento"]').val(id);
            }
         function editimg(id,descricao)
            {
               $('#teste').val(descricao).prop('selected', true);
               $('input[name="id_documento"]').val(id);
               $("#editimg").modal('show');
            }
        
         $(function(){
          // pega no SaudeControle, listarUm
            var interno = <?php echo $_SESSION['id_fichamedica']; ?>;
            console.log(interno);

         	  $.each(interno,function(i,item){
              if(i=1)
              {
                $("#formulario").append($("<input type='hidden' name='id_fichamedica' value='"+item.id+"'>"));
                //var cpf=item.cpf;
                $("#nome").text("Nome: "+item.nome+' '+item.sobrenome);
                $("#nome").val(item.nome + " " + item.sobrenome);
                // $("#sobrenome").val(item.sobrenome);
                if(item.imagem!=""){
                      $("#imagem").attr("src","data:image/gif;base64,"+item.imagem);
                    }else{
                      $("#imagem").attr("src","../../img/semfoto.png");
                    }
                if(item.sexo=="m")
                {
                  $("#sexo").html("Sexo: <i class='fa fa-male'></i>  Masculino");
                  $("#radioM").prop('checked',true);
                }
                else if(item.sexo=="f")
                {
                  $("#sexo").html("Sexo: <i class='fa fa-female'>  Feminino");
                  $("#radioF").prop('checked',true);
                }
              
                $("#nascimento").text("Data de nascimento: "+item.data_nascimento);
                $("#nascimento").val(item.data_nascimento);

                if(item.tipo_sanguineo==null || item.tipo_sanguineo == "")
                {
                    $("#adicionartipo").show(); 
                }
                if(item.tipo_sanguineo !=null && item.tipo_sanguineo != "")
                {
                  $("#exibirtipo").show();
                  $("#sangue").text("Sangue: "+item.tipo_sanguineo);
                  $("#sangue").val(item.tipo_sanguineo);
                }
          
              }
            });
          });
         
          // exame // 
          $(function() {
          var docfuncional = <?= $docfuncional ?>;
          $.each(docfuncional, function(i, item) {
            $("#dep-tab")
              .append($("<tr>")
                .append($("<td>").text(item.arquivo_nome))
                .append($("<td>").text(item.descricao))
                .append($("<td>").text(item.data))
                .append($("<td style='display: flex; justify-content: space-evenly;'>")
                  .append($("<a href='exame_download.php?id_doc=" + item.id_exame + "' title='Visualizar ou Baixar'><button class='btn btn-primary'><i class='fas fa-download'></i></button></a>"))
                  .append($("<a onclick='removerFuncionarioDocs("+item.id_exame+")' href='#' title='Excluir'><button class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></a>"))
                )
              )
            });
          });
          // importante para remover //
          function listarFunDocs(docfuncional){
                  $("#dep-tab").empty();
                $.each(docfuncional, function(i, item) {
                  $("#dep-tab")
                    .append($("<tr>")
                      .append($("<td>").text(item.arquivo_nome))
                      .append($("<td>").text(item.descricao))
                      .append($("<td>").text(item.data))
                      .append($("<td style='display: flex; justify-content: space-evenly;'>")
                        .append($("<a href='exame_download.php?id_doc=" + item.id_exame + "' title='Visualizar ou Baixar'><button class='btn btn-primary'><i class='fas fa-download'></i></button></a>"))
                        .append($("<a onclick='removerFuncionarioDocs("+item.id_exame+")' href='#' title='Excluir'><button class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></a>"))
                      )
                    )
                });
          }

          // enfermidade //
          $(function() {
          var enfermidades = <?= $enfermidades ?>;
          $.each(enfermidades, function(i, item) {
            $("#doc-tab")
              .append($("<tr>")
                .append($("<td>").text(item.descricao))
                .append($("<td>").text(item.data_diagnostico))
                .append($("<td style='display: flex; justify-content: space-evenly;'>")
                  .append($("<a onclick='removerEnfermidade("+item.id_CID+")' href='#' title='Excluir'><button class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></a>"))
                 
                )
              )
              console.log(item.id_CID);
                  console.log(item.descricao);
            });
          });
        
          function listarEnfermidades(enfermidades){
                  $("#doc-tab").empty();
                $.each(enfermidades, function(i, item) {
                  $("#doc-tab")
                    .append($("<tr>")
                      .append($("<td>").text(item.descricao))
                      .append($("<td>").text(item.data_diagnostico))
                      .append($("<td style='display: flex; justify-content: space-evenly;'>")
                  .append($("<a onclick='removerEnfermidade("+item.id_CID+")' href='#' title='Excluir'><button class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></a>"))
                )
              )
            });
          }

          //descricao medica 
          $(function() {
          var descricao_medica = <?= $descricao_medica ?>;
          $.each(descricao_medica, function(i, item) {
            $("#de-tab")
              .append($("<tr>")
                .append($("<td>").text(item.descricao))
                .append($("<td>").text(item.data_atendimento))
                /*.append($("<td style='display: flex; justify-content: space-evenly;'>")
                  .append($("<a onclick='removerDescricaoMedica("+item.id_atendimento+")' href='#' title='Excluir'><button class='btn btn-danger'><i class='fas fa-trash-alt'></i></button></a>"))
                )*/
              )
            });
          });

          $(function() {
          var exibimed = <?= $exibimed ?>;
          $.each(exibimed, function(i, item) {
            $("#exibimed")
              .append($("<tr>")
              .append($("<td>").text(item.data_atendimento))
                .append($("<td>").text(item.medicamento + ", " + item.dosagem + ", " + item.horario + ", " + item.duracao + "."))
                .append($("<td>").text(item.descricao))
                .append($("<td style='display: flex; justify-content: space-evenly;'>")
                  .append($("<a onclick='removerDescricaoMedica("+item.id_atendimento+")' href='#' title='Excluir'><button class='btn btn-primary'><i class='glyphicon glyphicon-pencil'></i></button></a>"))
                )
              )
            });
          });

          function listarMedicacoes(exibimed){
                  $("#exibimed").empty();
                $.each(exibimed, function(i, item) {
                  $("#exibimed")
                    .append($("<tr>")
                    .append($("<td>").text(item.data_atendimento))
                      .append($("<td>").text(item.medicamento + ", " + item.dosagem + ", " + item.horario + ", " + item.duracao + "."))
                      .append($("<td>").text(item.descricao))
                      .append($("<td style='display: flex; justify-content: space-evenly;'>")
                  .append($("<a onclick='removerDescricaoMedica("+item.id_atendimento+")' href='#' title='Excluir'><button class='btn btn-primary'><i class='glyphicon glyphicon-pencil'></i></button></a>"))
                )
              )
            });
          }

          $(function() {
          var exibimedparaenfermeiro = <?= $exibimedparaenfermeiro ?>;
          $.each(exibimedparaenfermeiro, function(i, item) {
            $("#exibimedparaenfermeiro")
              .append($("<tr>")
                .append($("<td>").text(item.medicamento))
                .append($("<td>").text(item.dosagem))
                .append($("<td>").text(item.horario))
                .append($("<td>").text(item.duracao))
                
              )
            });
          });
          
          // para diferente, aplicação do enfermeiro
          $(function(){
            var exibimedparaenfermeiro = <?= $exibimedparaenfermeiro ?>;
            
            $.each(exibimedparaenfermeiro,function(i,item){
              // let fSize = item.tamanho;
              // if (fSize >= 1000000000){
              //   fSize = (item.tamanho / 1000000000).toFixed(1) + " GB";
              // } else if (fSize >= 1000000){
              //   fSize = (item.tamanho / 1000000).toFixed(1) + " MB";
              // } else {
              //   fSize = (item.tamanho / 1000).toFixed(1) + " KB";
              // }
              $("#tabela")
              .append($("<tr class='item "+item.medicamento+"'>")
                .append($("<td class='txt-center'>")
                  .text(item.medicamento)
                )
                // .append($("<td class='txt-center'>")
                //   .text(fSize)
                // )
                .append($("<td class='txt-center'>")
                  .text(item.dosagem)
                )
                .append($("<td class='txt-center'>")
                  .text(item.horario)
                )
                .append($("<td class='txt-center'>")
                  .text(item.duracao)
                )
                /*.append($("<td class='txt-center'>")
                  .append($("<div class='btn-container'>")
                    .append($("<a href='#' onclick='confirmDownload(`"+item.id_medicacao+"`)'/>")
                      .append($("<button class='btn btn-success' />")
                        .html('<i class="fa fa-download" aria-hidden="true" style="font-family: FontAwesome;" />')
                      )
                    )
                    
                  )
                )*/
                .append($("<td style='display: flex; justify-content: space-evenly;'>")
                  
                  .append($("<a onclick='aplicarMedicacao("+item.id_medicacao+")' href='#' title='Excluir'><button class='btn btn-primary bot click'><i class='glyphicon glyphicon-hand-up'></i></button></a>"))
                  /*.append($("<a href='aplicacao_upload.php?id_doc=" + item.id_medicacao + "' title='Visualizar ou Baixar'><button class='btn btn-primary'><i class='glyphicon glyphicon-hand-up'></i></button></a>"))*/
                 
                )
              )
            });
          });

          // listar aplicacao enfermeiro
          $(function() {
          var medaplicadas = <?= $medaplicadas ?>;
          $.each(medaplicadas, function(i, item) {
            $("#exibiaplicacao")
              .append($("<tr>")
                .append($("<td>").text(item.medicamento))
                .append($("<td>").text(item.aplicacao))
              )
            });
          });

                $(function() {
                  $('#datatable-docfuncional').DataTable({
                    "order": [
                      [0, "asc"]
                    ]
                  });
                });
          
          function digitarmedicacao()
          {
            $("#AAA").remove();
            $("#Inputremedio").show();
          }
          function aparecermedicacao()
          {
            $("#botaoSalvarIP").show();
          }
          function esconderoutro()
          {
            $("#Inputremedio").hide();
          }


         $(function () {
            $("#header").load("../header.php");
            $(".menuu").load("../menu.php");
         });
       
      </script>
      <style type="text/css">
      .obrig {
        color: rgb(255, 0, 0);
      }
      </style>
        
    <!-- <script src="controller/script/valida_cpf_cnpj.js"></script> -->
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
               <h2>Informações paciente</h2>
               <div class="right-wrapper pull-right">
                  <ol class="breadcrumbs">
                     <li>
                        <a href="../index.php">
                        <i class="fa fa-home"></i>
                        </a>
                     </li>
                     <li><span>Informações paciente</span></li>
                  </ol>
                  <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
               </div>
            </header>
            <!-- start: page -->
            <div class="row">
            <div class="col-md-4 col-lg-3">
               <section class="panel">
                        <div class="panel-body">
                          <div class="alert alert-warning" style="font-size: 15px;">
                          <i class="fas fa-check mr-md"></i>O endereço da instituição não está cadastrado no sistema<br><a href=https://demo.wegia.org/html/personalizacao.php>Cadastrar endereço da instituição</a>
                        </div>

                            <div class="thumb-info mb-md">
                                  <img id="imagem" alt="John Doe">
                                <i class="fas fa-camera-retro btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></i>

                              <div class="container">
                                 <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                       <!-- Modal content-->
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                             <h4 class="modal-title">Adicionar uma Foto</h4>
                                          </div>
                                          <div class="modal-body">
                                             <form class="form-horizontal" method="POST" action="../../controle/control.php" enctype="multipart/form-data">
                                                <input type="hidden" name="nomeClasse" value="SaudeControle">
                                                <input type="hidden" name="metodo" value="alterarImagem">
                                                <div class="form-group">
                                                   <label class="col-md-4 control-label" for="imgperfil">Carregue nova imagem de perfil:</label>
                                                   <div class="col-md-8">
                                                      <input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
                                                   </div>
                                                </div>
                                          </div>
                                          <div class="modal-footer">
                                          <input type="hidden" name="id_fichamedica" value="<?php echo $_GET['id_fichamedica']?>">
                                          <input type="submit" id="formsubmit" value="alterarImagem">
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
                  <a href="#overview" data-toggle="tab">Informações Pessoais</a>
               </li>
               <li>
                  <a href="#cadastro_comorbidades" data-toggle="tab">Cadastro de comorbidades</a>
                </li>
                <li>
                  <a href="#arquivo" data-toggle="tab">Cadastro de exames</a>
               </li>
               <li>
                  <a href="#historico_medico" data-toggle="tab">Histórico Médico</a>
               </li>
               <li>
               <li>
                  <a href="#atendimento_medico" data-toggle="tab">Cadastro médico</a>
               </li>
               <li>
                  <a href="#atendimento_enfermeiro" data-toggle="tab">Aplicações enfermeiro</a>
               </li>
            </ul>
          
            <div class="tab-content">
              
                <div id="overview" class="tab-pane active">
                  <form class="form-horizontal" method="post" action="../../controle/control.php">
                    <input type="hidden" name="nomeClasse" value="SaudeControle">
                    <!-- <input type="hidden" name="metodo" value="alterarInfPessoal"> -->
                    <section class="panel">
                      <header class="panel-heading">
                        <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        </div>
                      <h2 class="panel-title">Informações pessoais</h2>
                      </header>
                    
                    <div class="panel-body">
                    <hr class="dotted short">
                    <fieldset>
                      
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">Nome</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" disabled name="nome" id="nome" onkeypress="return Onlychars(event)">
                        </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-3 control-label" for="profileLastName">Sexo</label>
                        <div class="col-md-8">
                          <label><input type="radio" name="gender" id="radioM" id="M" disabled value="m" style="margin-top: 10px; margin-left: 15px;" onclick="return exibir_reservista()"> <i class="fa fa-male" style="font-size: 20px;"> </i></label>
                          <label><input type="radio" name="gender" id="radioF" disabled id="F" value="f" style="margin-top: 10px; margin-left: 15px;" onclick="return esconder_reservista()"> <i class="fa fa-female" style="font-size: 20px;"> </i> </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="profileCompany">Nascimento</label>
                        <div class="col-md-8">
                          <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" disabled id="nascimento" max=<?php echo date('Y-m-d'); ?>>
                        </div>
                    </div>

                    <!-- caso o paciente já tenha o tipo sanguíneo definido -->
                      <div class="form-group" id="exibirtipo" style="display:none;">
                        <label class="col-md-3 control-label" for="inputSuccess">Tipo sanguíneo</label>
                        <div class="col-md-6">
                          <input class="form-control input-lg mb-md" name="tipoSanguineo" disabled id="sangue">
                        </div>
                      </div> 


                      <!-- caso o paciente não tenha o tipo sanguineo definido -->
                      <div id="adicionartipo" style="display:none;" class="form-group">
                      <input type="hidden" name="metodo" value="alterarInfPessoal">

                      <label class="col-md-3 control-label" for="inputSuccess">Tipo sanguíneo</label>
                        <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="tipoSanguineo" id="tipoSanguineo">
                            <option selected>Selecionar</option>
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

                      <!-- </div> -->
                      <input type="hidden" name="id_fichamedica" value=<?php echo $_GET['id_fichamedica'] ?>>
                     <div class="col-md-9 col-md-offset-3">
                        <input type="submit" class="btn btn-primary" value="Salvar" id="botaoSalvarIP">
                      </div> 
                     </div>
                    </div>
                    </section>
                  </form>
                </div>

                    
    <!-- Aba  de  comorbidades -->
    <div id="cadastro_comorbidades" class="tab-pane">
        <section class="panel">
            <header class="panel-heading">
              <div class="panel-actions">
                  <a href="#" class="fa fa-caret-down"></a>
              </div>
                <h2 class="panel-title">Cadastro de comorbidades</h2>
            </header>
            <div class="panel-body">

            <hr class="dotted short">
            
            <table class="table table-bordered table-striped mb-none" id="datatable-dependente">
                <thead>
                    <tr style="font-size:15px;">
                        <th>Enfermidade</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                    <!-- id="doc tab" -->
                    <tbody id="doc-tab">
                            
                    </tbody>
            </table>
               <br> 
                <form action='enfermidade_upload.php' method='post' enctype='multipart/form-data' id='funcionarioDocForm'>
                  <h5 class="obrig">Campos Obrigatórios(*)</h5>
                    <div class="modal-body" style="padding: 15px 40px">
                      <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">Enfermidades</label>
                          <div class="col-md-8">
                          <select class="form-control input-lg mb-md" name="id_CID" id="id_CID" style="width:350px;" required>
                          <option selected disabled>Selecionar</option>
                            <?php
                            while ($row = $tabelacid->fetch_array(MYSQLI_NUM)) {
                            echo "<option value=" . $row[0] . ">" . $row[2] . "</option>";
                            }
                            ?>
                          </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-3 control-label" for="inputSuccess" id="data_diagnostico">Data do diagnóstico</label>
                          <div class="col-md-6">
                            <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" name="data_diagnostico" id="data_diagnostico" max=2021-06-11>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-3 control-label" for="inputSuccess">Status</label>
                          <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="intStatus" id="intStatus"> <!-- tinha um required aq de obrigatorio -->
                            <option selected disabled>Selecionar</option>
                            <!-- <?php
                              while ($row = $intStatus->fetch_array(MYSQLI_NUM)) {
                              echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                              }
                            ?> -->
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                          </select>
                        </div>
                        </div>
                        
                        <input type="number" name="id_fichamedica" value="<?= $_GET['id_fichamedica']; ?>" style='display: none;'>
                          <input type="hidden" name="id_fichamedica" value=<?php echo $_GET['id_fichamedica'] ?>>
                          <input type="submit" class="btn btn-primary" value="Cadastrar" id="botaoSalvarIP">
                      <div> 
                    </form>
                  </div>
            </section>
            
         </div>



        <!-- Aba de exames -->
          <div id="arquivo" class="tab-pane">
              <section class="panel">
                <header class="panel-heading">
                 <div class="panel-actions">
                   <a href="#" class="fa fa-caret-down"></a>
                  </div>
                  <h2 class="panel-title">Exames</h2>
                </header>
                <div class="panel-body">
                <hr class="dotted short">
                      <table class="table table-bordered table-striped mb-none">
                        <thead>
                          <tr style="font-size:15px;">
                            <th>Arquivo</th>
                            <th>Tipo exame</th>
                            <th>Data exame</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="dep-tab" style="font-size:15px">
                          
                        </tbody>
                      </table>
                      <br>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docFormModal">
                        Adicionar
                      </button>
                      <div class="modal fade" id="docFormModal" tabindex="-1" role="dialog" aria-labelledby="docFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">

                            <div class="modal-header" style="display: flex;justify-content: space-between;">
                              <h5 class="modal-title" id="exampleModalLabel">Adicionar exame</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                            <form action='exame_upload.php' method='post' enctype='multipart/form-data' id='funcionarioDocForm'>
                              <div class="modal-body" style="padding: 15px 40px">
                                <div class="form-group" style="display: grid;">

                                  <div class="form-group">
                                    <label for="arquivoDocumento">Exame</label>
                                    <input name="arquivo" type="file" class="form-control-file" id="id_documento" accept="png;jpeg;jpg;pdf;docx;doc;odp" required>
                                  </div>

                                  <label class="my-1 mr-2" for="tipoDocumento">Tipo de exame</label><br>
                                  <div style="display: flex;">
                                    <select class="form-control input-lg mb-md" name="id_docfuncional" id="tipoDocumento" style="width:170px;" required>
                                    <option selected disabled>Selecionar</option>
                                      <?php
                                      while ($row = $tipoexame->fetch_array(MYSQLI_NUM)) {
                                      echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                               
                                <div class="form-group">
                                <label>Data do exame</label>
                                <div style="display: flex;">
                                  <input type="date" class="form-control"  maxlength="10" placeholder="dd/mm/aaaa" name="data_diagnostico" id="data_diagnostico" max=2021-06-11>
                                </div>
                              </div>
                              <input type="number" name="id_fichamedica" value="<?= $_GET['id_fichamedica']; ?>" style='display: none;'>
                                <!-- <input type="number" name="id_interno" value="" style='display: none;'> -->
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <input type="submit" value="Enviar" class="btn btn-primary">
                              </div>
                            </form>
                            </div>
                          </div>
                        </div>
                    <br/>
         </section>
         </div>
       
      <!-- aba de atendimento médico -->
       <div id="historico_medico" class="tab-pane">
         <section class="panel">
            <header class="panel-heading">
               <div class="panel-actions">
                  <a href="#" class="fa fa-caret-down"></a>
               </div>
               <h2 class="panel-title">Histórico Médico</h2>
            </header>
               
            <div class="panel-body">
            <hr class="dotted short">
              <div class="form-group">
                <table class="table table-bordered table-striped mb-none">
                  <thead>
                    <tr style="font-size:15px;">
                      <th>Descrições</th>
                      <th>Data do atendimento</th>
                    </tr>
                  </thead>
                  <tbody id="de-tab" style="font-size:15px">                
                  
                 </tbody>
               </table>
             </div>
              
             <div class="form-group">
             <hr class="dotted short">
                <table class="table table-bordered table-striped mb-none">
                  <thead>
                    <tr style="font-size:15px;">
                      <th>Data do atendimento</th>
                      <th>Medicações</th>
                      <th>Status</th>
                      <th>Ação</th>
                    </tr>
                  </thead>
                  <tbody id="exibimed" style="font-size:15px">                
                  
                 </tbody>
               </table>
                </div>
              <br>
            </div>
          </section>
       </div>

      <!-- aba de cadastro médico -->
      <div id="atendimento_medico" class="tab-pane">
         <section class="panel" id="medicacao">
             <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                </div>

             <h2 class="panel-title">Cadastro</h2>
             </header>
             <div class="panel-body">
             <div class="form-group" id="escondermedicacao">

             <form action='atendmedico_upload.php' method='post' enctype='multipart/form-data' id='funcionarioDocForm'>

              <hr class="dotted short">
              
                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany" id="data_atendimento">Data do atendimento:</label>
                     <div class="col-md-6">
                     <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" name="data_atendimento" id="data_atendimento" max=2021-06-11>
                     </div>
                    
                   </div>
                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany"></label>
                     <div class="col-md-6">
                       <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                     </div>
                   </div>


                   <!-- listar o funcionario, pessoa nome onde cargo = 3 -->
                   <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">Médico:</label>
                        <div class="col-md-8">
                          <input class="form-control" style="width:230px;" name="medico" id="medico" value="<?php echo $id_funcionario; ?>" disabled="true">
                          </div>
                      </div>

                   <div class="form-group">
                     <label class="col-md-3 control-label" for="profileCompany">Descrição:</label>
                       <div class='col-md-6' id='div_texto' style="height: 499px;">
                        <textarea cols='30' rows='3' id='despacho' name='texto' required class='form-control'></textarea>
                        </div>
                      </div>

                      <br>

                      <div class="form-group" id="AAA">
                        <label class="col-md-3 control-label" for="inputSuccess">Medicação:</label>
                        <div class="col-md-6">
                          <select class="form-control input-lg mb-md" name="nome_medicacao" id="nome_medicacao">
                            <option selected disabled>Selecionar</option>
                            <option value="Dipirona">Dipirona</option>
                            <option value="Neosaldina">Neosaldina</option>
                            <option value="Benegripe">Benegripe</option>
                            <option value="Torsilax">Torsilax</option>
                            <option value="Puran">Puran</option>
                            <option value="Ibuprofeno">Ibuprofeno</option>
                            <option value="Amoxicilina">Amoxicilina</option>
                            <option value="outro" onclick="digitarmedicacao();" id="outro">Outro</option>
                          </select>
                        </div>
                      </div>
                                    </div>

                      <!-- caso não tenha a medicacao no select -->
                      <div id="Inputremedio" style="display:none;">
                        <div class="form-group">
                        <label class="col-md-3 control-label" for="profileCompany">Nome da medicação:</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="nome_medicacao" id="nome_medicacao" placeholder="informe a medicação">
                        </div>
                        </div>
                        <br>
                      </div>
                    
                    <!-- <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Laboratório:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="laboratorio" id="laboratorio">
                      </div>
                    </div> -->

                    <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Dosagem:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="dosagem" id="dosagem" onkeypress="return Onlychars(event)">
                      </div>
                     </div>

                     <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Horário:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="horario_medicacao" id="horario_medicacao" onkeypress="return Onlychars(event)">
                      </div>
                   </div>

                   <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Duração:</label>
                     <div class="col-md-6">
                       <input type="text" class="form-control" name="duracao_medicacao" id="duracao_medicacao" onkeypress="return Onlychars(event)">
                     </div>
                   </div>
                  
                   <br>
                   <hr class="dotted short">
                      <table class="table table-bordered table-striped mb-none" id="tabmed">
                        <thead>
                          <tr style="font-size:15px;">
                            <th>Medicação</th>
                            <th>Dosagem</th>
                            <!--<th>Laboratório</th>-->
                            <th>Horário</th>
                            <th>Duração</th>
                            <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody id="dep-tab" style="font-size:15px">
                          
                      </tbody>
                      </table>
                      <br> 
                   <br>
                   <button type="button" class="btn btn-success" id="botao">Prescrever medicação</button>  
                 <br>
                 <br>
                 <input type="number" name="id_fichamedica" value="<?= $_GET['id_fichamedica']; ?>" style='display: none;'>
                <input type="hidden" name="acervo">
                <!-- value=<?php echo $_GET['id_fichamedica'] ?>-->
                <input type="submit" class="btn btn-primary" value="Cadastrar atendimento e medicação" id="salvar_bd">
              <!-- id="salvar_bd" -->
            </div>
          </form>
          </section>
       </div>
      
       
       <!-- aba de atendimento enfermeiro -->
       <div id="atendimento_enfermeiro" class="tab-pane">                           
                <section class="panel">
                   <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                    </div>
                   <h2 class="panel-title">Aplicar medicação</h2>
                </header>
                   
                <form action='aplicacao_upload.php' method='post' enctype='multipart/form-data' id='funcionarioDocForm'>
                   <div class="panel-body">
                   <hr class="dotted short">
                   
                    <!-- <div class="form-group">
                    <table class="table table-bordered table-striped mb-none">
                      <thead>
                        <tr style="font-size:15px;">
                          <th>Medicações</th>
                          <th>Dosagem</th>
                          <th>Horário</th>
                          <th>Duração</th>
                        </tr>
                      </thead>
                      <tbody id="exibimedparaenfermeiro" style="font-size:15px">                
                      
                    </tbody>
                  </table>
                  <br>
                </div> -->
                <table class="table table-bordered table-striped mb-none" id="datatable-default">
							<thead>
								<tr>
									<th class='txt-center' width='30%'>Medicações</th>
									<th class='txt-center' width='15%'>Dosagem</th>
									<th class='txt-center' width='15%'>Horário</th>
									<th class='txt-center' width='15%'>Duração</th>
									<th class='txt-center'>Aplicar</th>
								</tr>
							</thead>
							<tbody id="tabela">
							</tbody>
						</table>
<!-- 
                  <div class="form-group">
                        <label class="col-md-3 control-label" for="inputSuccess">Medicamento:</label>
                        <div class="col-md-8">
                          <select class="form-control input-lg mb-md" name="med" id="med" style="width:235px;" required>
                          <option selected disabled>Selecionar</option>
                            <?php
                            while ($row = $medicamentoenfermeiro->fetch_array(MYSQLI_NUM)) {
                            echo "<option value=" . $row[2] . ">" . $row[2] . "</option>";
                            }
                            ?>
                          </select>
                          </div>
                      </div> -->
                      <!-- <div class="form-group">
                      <label class="col-md-3 control-label" for="profileCompany">Horário de aplicação:</label>
                     <div class="col-md-6">
                       <input type="text" class="form-control" name="horario_aplicacao" id="horario_aplicacao"">
                     </div>
                     </div> -->
                    
                      
                     <br />
                     <!-- <button type="button" class="btn btn-success" id="botaoenferm">Aplicar medicação</button>

                     <br />
                     <br /> -->

                     <!-- <h2 class="panel-title">Aplicações efetuadas</h2> -->
                     
                     <table class="table table-bordered table-striped mb-none" id="enf">
                      <thead>
                        <tr style="font-size:15px;">
                          <th>Medicações aplicadas</th>
                          <th>Horário da aplicação</th>
                        </tr>
                      </thead>
                      <tbody id="exibiaplicacao" style="font-size:15px">                
                      
                    </tbody>
                  </table>
                    
                  <br>
                  <br>
                  
                  <input type="hidden" name="a_enf">
                  <!--<input id="salvar_enf" type="submit" class="btn btn-primary" value="Cadastrar aplicação desses medicamentos">-->
                 </form>
         </section>
       </div>  
       

       
         <aside id="sidebar-right" class="sidebar-right">
            <div class="nano">
               <div class="nano-content">
                  <a href="#" class="mobile-close visible-xs">
                  Collapse <i class="fa fa-chevron-right"></i>
                  </a>
                  <div class="sidebar-right-wrapper">
                     <div class="sidebar-widget widget-calendar">
                        <h6>Upcoming Tasks</h6>
                        <div data-plugin-datepicker data-plugin-skin="dark" ></div>
                        <ul>
                           <li>
                              <time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
                              <span>Company Meeting</span>
                           </li>
                        </ul>
                     </div>
                     <div class="sidebar-widget widget-friends">
                        <h6>Friends</h6>
                        <ul>
                           <li class="status-online">
                              <figure class="profile-picture">
                                 <img src="../../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                           <li class="status-online">
                              <figure class="profile-picture">
                                 <img src="../../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                           <li class="status-offline">
                              <figure class="profile-picture">
                                 <img src="../../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                           <li class="status-offline">
                              <figure class="profile-picture">
                                 <img src="../../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </aside>
      </section>
		<!-- Vendor -->
		<script src="../../assets/vendor/select2/select2.js"></script>
        <script src="../../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="../../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="../../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
        <!-- Theme Custom -->
        <script src="../../assets/javascripts/theme.custom.js"></script>
        <!-- Theme Initialization Files -->
        <!-- Examples -->
        <script src="../../assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="../../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="../../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
         <div class="modal fade" id="excluirimg" role="dialog">
         <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
         <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">×</button>
	      <h3>Excluir um Documento</h3>
         </div>
         <div class="modal-body">
         <p> Tem certeza que deseja excluir a imagem desse documento? Essa ação não poderá ser desfeita! </p>
         <form action="../../controle/control.php" method="GET">
            <input type="hidden" name="id_documento" id="excluirdoc">
            <input type="hidden" name="nomeClasse" value="DocumentoControle">
            <input type="hidden" name="metodo" value="excluir">
            <input type="hidden" name="id" value="">
            <input type="submit" value="Confirmar" class="btn btn-success">
            <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         </form>
         </div>
         </div>
         </div>
         </div>
         <iv class="modal fade" id="editimg" role="dialog">
         <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">×</button>
         <h3>Alterar um Documento</h3>
         </div>
         <div class="modal-body">
         <p> Selecione o benefício referente a nova imagem</p>
         <form action="../../controle/control.php" method="POST" enctype="multipart/form-data">
            <select name="descricao" id="teste">
               <option value="Certidão de Nascimento">Certidão de Nascimento</option>
               <option value="Certidão de Casamento">Certidão de Casamento</option>
               <option value="Curatela">Curatela</option>
               <option value="INSS">INSS</option>
               <option value="LOAS">LOAS</option>
               <option value="FUNRURAL">FUNRURAL</option>
               <option value="Título de Eleitor">Título de Eleitor</option>
               <option value="CTPS">CTPS</option>
               <option value="SAF">SAF</option>
               <option value="SUS">SUS</option>
               <option value="BPC">BPC</option> 
               <option value="CPF">CPF</option>
               <option value="Registro Geral">RG</option>
            </select><br/>
            
            <p> Selecione a nova imagem</p>
            <div class="col-md-12">
               <input type="file" name="doc" size="60"  class="form-control" > 
            </div><br/>
            <input type="hidden" name="id_documento" id="id_documento">
            <input type="hidden" name="id" value="">
            <input type="hidden" name="nomeClasse" value="DocumentoControle">
            <input type="hidden" name="metodo" value="alterar">
            <input type="submit" value="Confirmar" class="btn btn-success">
            <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         </form>
         </div>
         </div>
         </div>
         </div>
         
      <script>
          function removerFuncionarioDocs(id_doc) {
                if (!window.confirm("Tem certeza que deseja remover esse exame?")){
                  return false;
                }
                let url = "exame_excluir.php?id_doc="+id_doc+"&id_fichamedica=<?= $_GET['id_fichamedica'] ?>";
                let data = "";
                post(url, data, listarFunDocs);
                console.log(listarFunDocs);
            } 
            function removerEnfermidade(id_doc) {
                if (!window.confirm("Tem certeza que deseja remover essa enfermidade?")){
                  return false;
                }
                let url = "enfermidade_excluir.php?id_doc="+id_doc+"&id_fichamedica=<?= $_GET['id_fichamedica'] ?>";
                let data = "";
                post(url, data, listarEnfermidades);
                console.log(listarEnfermidades);
            } 
            /*function removerMedicacoes(id_doc) {
                if (!window.confirm("Tem certeza que deseja remover essa medicação?")){
                  return false;
                }
                let url = "medicacao_excluir.php?id_doc="+id_doc+"&id_fichamedica=<?= $_GET['id_fichamedica'] ?>";
                let data = "";
                post(url, data, listarMedicacoes);
            } */
            function aplicarMedicacao(id_doc) {
                if (!window.confirm("Tem certeza que deseja aplicar essa medicação?")){
                  return false;
                }
                //document.querySelector(".bot click").style.background = 'Red';
                let url = "mudarcor.php?id_doc="+id_doc+"&id_fichamedica=<?= $_GET['id_fichamedica'] ?>";
                let data = "";
                post(url, data);
                

            } 

            // codigo para inserir medicacao na tabela do medico
            $(function(){

                let tabela_medicacao = new Array();

                $("#botao").click(function(){
                
                let medicamento = $("#nome_medicacao").val();
                let dose = $("#dosagem").val();
                let horario = $("#horario_medicacao").val();
                let duracao =  $("#duracao_medicacao").val();
                    
                $("#tabmed").append($("<tr>").addClass("tabmed")
                  .append($("<td>") .text(medicamento) )
                  .append($("<td>") .text(dose) )
                  .append($("<td>") .text(horario) )
                  .append($("<td>") .text(duracao) )
                  .append($("<td style='display: flex; justify-content: space-evenly;'>")
                  .append($("<button class='btn btn-danger'><i class='fas fa-trash-alt'></i></button>"))));
               
                        let tabela = {
                                "nome_medicacao": medicamento,
                                "dosagem": dose,
                                "horario": horario,
                                "tempo": duracao
                            };
                        tabela_medicacao.push(tabela);
                        $("#dosagem").val("");
                        $("#horario_medicacao").val(""); 
                        $("#duracao_medicacao").val("");
                })
                $("#tabmed").on("click", "td", function(){

                    let tamanho = tabela_medicacao.length;
                    
                    let dados = tabela_medicacao[0].medicamento + tabela_medicacao[0].dose + tabela_medicacao[0].horario + tabela_medicacao[0].duracao;
                    let dados_existentes = $(this).parents("#tabmed tr").text();
                    if(dados == dados_existentes)
                    {
                        tabela_medicacao.splice(0,1);
                    }
                    else
                    {
                        let i;
                        for(i=1;i<tamanho;i++)
                        {
                            let dd = tabela_medicacao[i].medicamento + tabela_medicacao[i].dose + tabela_medicacao[i].horario + tabela_medicacao[i].duracao;
                            if(dd == dados_existentes)
                            {   
                                tabela_medicacao.splice(i,1);
                            }
                        }
                    }
                    $(this).parents("#tabmed tr").remove();
                })

                  $("#salvar_bd").click(function(){
                    $("input[name=acervo]").val(JSON.stringify(tabela_medicacao)).val();
                  })

                });

                // insercao das meds no enfermeiro 
                $(function(){

                  let tabela_enfermeiro = new Array();

                  $("#botaoenferm").click(function(){
                  let horario_aplicacao = $("#horario_aplicacao").val();
                  let medicamento = $("#med").val();

                  $("#enf").append($("<tr>")
                      .append($("<td>") .text(medicamento) )
                      .append($("<td>") .text(horario_aplicacao) )
                      .append($("<td style='display: flex; justify-content: space-evenly;'>")
                      .append($("<button class='btn btn-danger'><i class='fas fa-trash-alt'></i></button>"))));
                      
                      let tabela = {
                             "horario_aplicacao": horario_aplicacao,
                             "med":medicamento,
                       };
                      tabela_enfermeiro.push(tabela);
                      $("#horario_aplicacao").val(""); 
                      $("#med").val("");
                  })

                  $("#enf").on("click", "td", function(){

                      let tamanho = tabela_enfermeiro.length;
                      let dados = tabela_enfermeiro[0].medicamento + tabela_enfermeiro[0].horario_aplicacao;
                      let dados_existentes = $(this).parents("#enf tr").text();
                      if(dados == dados_existentes)
                      {
                          tabela_enfermeiro.splice(0,1);
                      }
                      else
                      {
                          let i;
                          for(i=1;i<tamanho;i++)
                          {
                              let dd = tabela_enfermeiro[i].medicamento + tabela_enfermeiro[i].horario_aplicacao;
                              if(dd == dados_existentes)
                              {   
                                  tabela_enfermeiro.splice(i,1);
                              }
                          }
                      }
                      $(this).parents("#enf tr").remove();
                  })
                  $("#salvar_enf").click(function(){
                      $("input[name=a_enf]").val(JSON.stringify(tabela_enfermeiro)).val();
                  })
                  });
           
        </script>
        
        <!-- Vendor -->
        <script src="<?php echo WWW;?>assets/vendor/select2/select2.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
        
        <!-- Theme Custom -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>

        <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
        
        <!-- Theme Initialization Files -->
        <!-- Examples -->
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
        
        <!-- importante para a aba de exames -->
        <script src="../geral/post.js"></script>
        <script src="../geral/formulario.js"></script>
  </body>
</html> 
