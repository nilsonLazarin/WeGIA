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

     if(!isset($_SESSION['atendido_ocorrencia']))	{
      header('Location: ../../controle/control.php?metodo=listarUm&nomeClasse=Atendido_ocorrenciaControle&nextPage=../html/atendido/listar_ocorrencias.php');
    }

      $config_path = "config.php";
      if(file_exists($config_path)){
         require_once($config_path);
      }else{
         while(true){
            $config_path = "../" . $config_path;
            if(file_exists($config_path)) break;
         }
         require_once($config_path);
      }

      $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $id_pessoa = $_SESSION['id_pessoa'];
      $resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
      if(!is_null($resultado)){
         $id_cargo = mysqli_fetch_array($resultado);
         if(!is_null($id_cargo)){
            $id_cargo = $id_cargo['id_cargo'];
         }
         $resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=12");
         if(!is_bool($resultado) and mysqli_num_rows($resultado)){
            $permissao = mysqli_fetch_array($resultado);
            if($permissao['id_acao'] < 7){
           $msg = "Você não tem as permissões necessárias para essa página.";
           header("Location: ../../home.php?msg_c=$msg");
            }
            $permissao = $permissao['id_acao'];
         }else{
              $permissao = 1;
             $msg = "Você não tem as permissões necessárias para essa página.";
             header("Location: ../../home.php?msg_c=$msg");
         }	
      }else{
         $permissao = 1;
       $msg = "Você não tem as permissões necessárias para essa página.";
       header("Location: ./home.php?msg_c=$msg");
      }	
  

  include_once '../../classes/Cache.php';    
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
  require_once "../personalizacao_display.php";
  require_once "../../controle/Atendido_ocorrenciaControle.php";
  
  /*require_once ROOT."/controle/FuncionarioControle.php";
  $cpf1 = new FuncionarioControle;
  $cpf1->listarCpf();*/

  // require_once ROOT."/controle/SaudeControle.php";
  /*$cpf = new AtendidoControle;
  $cpf->listarCpf();*/
 
  /*require_once ROOT."/controle/EnderecoControle.php";
  $endereco = new EnderecoControle;
  $endereco->listarInstituicao();*/
   
   
   $id=$_GET['id']; 
   $cache = new Cache();
   $teste = $cache->read($id);
   //$atendidos = $_SESSION['idatendido'];
   // $atendido = new AtendidoDAO();
   // $atendido->listar($id);
   // var_dump($atendido);
  
  //  $sessao_saude = $_SESSION['id_fichamedica'];
   
   if (!isset($teste)) {
     
    header('Location: ../../controle/control.php?metodo=listarUm&nomeClasse=Atendido_ocorrenciaControle&nextPage=../html/atendido/listar_ocorrencias.php?id='.$id.'&id='.$id);
      }
   
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
        
    <!-- jquery functions -->

    <script>
        $(function(){
            // var funcionario=[];
            // $.each(funcionario,function(i,item){
            //     $("#destinatario")
            //         .append($("<option id="+item.id_pessoa+" value="+item.id_pessoa+" name="+item.id_pessoa+">"+item.nome+" "+item.sobrenome+"</option>"));
            // });
            $("#header").load("../header.php");
            $(".menuu").load("../menu.php");

            //var id_memorando = 1;
            //$("#id_memorando").val(id_memorando);

            // CKEDITOR.replace('despacho');
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
      <title>Informações </title>
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
      </script> <script src="../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script> <script src="../../assets/vendor/bootstrap/js/bootstrap.js"></script> <script src="../../assets/vendor/nanoscroller/nanoscroller.js"></script>
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
            var interno = <?php echo $_SESSION['atendido_ocorrencia']; ?>;
            
            console.log(interno);
         	  $.each(interno,function(i,item){
         		if(i=1)
         		{
              $("#formulario").append($("<input type='hidden' name='id_fichamedica' value='"+item.id+"'>"));
         			//var cpf=item.cpf;
         			$("#nome").text("Nome: "+item.nome+' '+item.sobrenome);
         			$("#nome").val(item.nome);
              $("#sobrenome").val(item.sobrenome);
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
         			$("#sangueSelect").text(item.tipo_sanguineo);
         			$("#sangueSelect").val(item.tipo_sanguineo);
         			
         			$("#nascimento").text("Data de nascimento: "+item.data_nascimento);
         			$("#nascimento").val(item.data_nascimento);
         
               if(item.imgdoc==null)
               {
                  $('#docs').append($("<strong >").append($("<p >").text("Não foi possível encontrar nenhuma imagem referente a esse Paciente!")));
               }
             }
         	});
         });
        //  });
         $(function () {
            $("#header").load("../header.php");
            $(".menuu").load("../menu.php");
         });
      //</script>
      
    <script src="controller/script/valida_cpf_cnpj.js"></script>
   </head>
   <body>
   <section class="body">
        <!-- start: header -->
        <div id="header"></div>
        <!-- end: header -->
        <div class="inner-wrapper">
            <!-- start: sidebar -->
            <aside id="sidebar-left" class="sidebar-left menuu"></aside>
            <!-- end: sidebar -->
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Informações da ocorrência</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="home.php">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Informações da ocorrência</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
               

                <div class="row">
                    <div class="col-md-8 col-lg-12">
                        <div class="tabs">
                            <ul class="nav nav-tabs tabs-primary">
                                <li class="active">
                                    <a href="#overview" data-toggle="tab">Informações da ocorrência</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="overview" class="tab-pane active">
                                    <form class="form-horizontal"  id="doc" method="GET" action="../../controle/control.php">
                                    <section class="panel">  
                                        <header class="panel-heading">
                                            <div class="panel-actions">
                                                <a href="#" class="fa fa-caret-down"></a>
                                            </div>
                                            <h2 class="panel-title">Informações</h2>
                                        </header>
                                        <div class="panel-body">    
                                            <!-- <h5 class="obrig">Campos Obrigatórios(*)</h5> -->
                                            <br>

                                            <div class="form-group">
											<label class="col-md-2 control-label" for="profileFirstName">Nome</label>
											<div class="col-md-8">
												<input type="text" class="form-control" disabled name="nome" id="nome" id="profileFirstName" onkeypress="return Onlychars(event)"required>
											</div>
										</div>
                                
                    <div class="form-group">
											<label class="col-md-2 control-label" for="profileFirstName">Tipo da ocorrência</label>
											<div class="col-md-8">
												<input type="text" class="form-control" disabled name="nome" id="tipo" id="tipo" onkeypress="return Onlychars(event)"required>
											</div>
										</div>

                    <div class="form-group">
											<label class="col-md-2 control-label" for="profileFirstName">Autor da ocorrência</label>
											<div class="col-md-8">
												<input type="text" class="form-control" disabled name="nome" id="funcionario" id="funcionario" onkeypress="return Onlychars(event)"required>
											</div>
										</div>
                    <div class="form-group">
                     <label class="col-md-2 control-label" for="profileCompany">Data</label>
                     <div class="col-md-6">
                     <input type="date" class="form-control" disabled maxlength="10" placeholder="dd/mm/aaaa" name="data" id="data" max=2021-06-11>
                     </div>
                   </div>
                    <div class="form-group">
											<label class="col-md-2 control-label" for="profileFirstName">Descrição</label>
											<div class="col-md-8">
												<input type="text" class="form-control" disabled name="descricao" id="descricao" id="profileFirstName" onkeypress="return Onlychars(event)"required>
											</div>
										</div>
                                            <br>
                                            <!-- <div class="panel-footer">
                                                <div class='row'>
                                                    <div class="col-md-9 col-md-offset-3">
                                                        <input type="hidden" name="nomeClasse" value="SaudeControle">
                                                        <input type="hidden" name="metodo" value="incluir">
                                                        <input id="enviar" type="submit" class="btn btn-primary" value="Enviar">
                                                    </div>
                                                </div>
        -->
                                            </div> 
                                            </form>
                                          </div>
                                    </section>
                                </div>      <!-- </form> -->
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            
            </section>
        </div>
    </section><!--section do body-->
    
        
    <!-- end: page -->
    <!-- Vendor -->
        <script src="<?php echo WWW;?>assets/vendor/select2/select2.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
        
        <!-- Theme Base, Components and Settings -->
        <!-- <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script> -->
        
        <!-- Theme Custom -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
        <!-- Theme Initialization Files -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>
        <!-- Examples -->
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
    </body>
</html>